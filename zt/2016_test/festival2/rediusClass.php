<?php
/**
 * Redis ������֧�� Master/Slave �ĸ��ؼ�Ⱥ
 *
 * @author jackluo
 */
 
date_default_timezone_set('Asia/Shanghai'); 
header("Content-type: text/html; charset=utf-8"); 
class RedisCluster{
       
    // �Ƿ�ʹ�� M/S �Ķ�д��Ⱥ����
    private $_isUseCluster = false;
       
    // Slave ������
    private $_sn = 0;
       
    // ���������Ӿ��
    private $_linkHandle = array(
        'master'=>null,// ֻ֧��һ̨ Master
        'slave'=>array(),// �����ж�̨ Slave
    );
       
    /**
     * ���캯��
     *
     * @param boolean $isUseCluster �Ƿ���� M/S ����
     */
    public function __construct($isUseCluster=false){
        $this->_isUseCluster = $isUseCluster;
    }
       
    /**
     * ���ӷ�����,ע�⣺����ʹ�ó����ӣ����Ч�ʣ��������Զ��ر�
     *
     * @param array $config Redis����������
     * @param boolean $isMaster ��ǰ��ӵķ������Ƿ�Ϊ Master ������
     * @return boolean
     */
    public function connect($config=array('host'=>'127.0.0.1','port'=>6379), $isMaster=true){
        // default port
        if(!isset($config['port'])){
            $config['port'] = 6379;
        }
        // ���� Master ����
        if($isMaster){
            $this->_linkHandle['master'] = new Redis();
            $ret = $this->_linkHandle['master']->pconnect($config['host'],$config['port']);
        }else{
            // ��� Slave ����
            $this->_linkHandle['slave'][$this->_sn] = new Redis();
            $ret = $this->_linkHandle['slave'][$this->_sn]->pconnect($config['host'],$config['port']);
            ++$this->_sn;
        }
        return $ret;
    }
       
    /**
     * �ر�����
     *
     * @param int $flag �ر�ѡ�� 0:�ر� Master 1:�ر� Slave 2:�ر�����
     * @return boolean
     */
    public function close($flag=2){
        switch($flag){
            // �ر� Master
            case 0:
                $this->getRedis()->close();
            break;
            // �ر� Slave
            case 1:
                for($i=0; $i<$this->_sn; ++$i){
                    $this->_linkHandle['slave'][$i]->close();
                }
            break;
            // �ر�����
            case 1:
                $this->getRedis()->close();
                for($i=0; $i<$this->_sn; ++$i){
                    $this->_linkHandle['slave'][$i]->close();
                }
            break;
        }
        return true;
    }
       
    /**
     * �õ� Redis ԭʼ��������и���Ĳ���
     *
     * @param boolean $isMaster ���ط����������� true:����Master false:����Slave
     * @param boolean $slaveOne ���ص�Slaveѡ�� true:���ؾ����������һ��Slaveѡ�� false:�������е�Slaveѡ��
     * @return redis object
     */
    public function getRedis($isMaster=true,$slaveOne=true){
        // ֻ���� Master
        if($isMaster){
            return $this->_linkHandle['master'];
        }else{
            return $slaveOne ? $this->_getSlaveRedis() : $this->_linkHandle['slave'];
        }
    }
       
    /**
     * д����
     *
     * @param string $key ���KEY
     * @param string $value ����ֵ
     * @param int $expire ����ʱ�䣬 0:��ʾ�޹���ʱ��
     */
    public function set($key, $value, $expire=0){
        // ������ʱ
        if($expire == 0){
            $ret = $this->getRedis()->set($key, $value);
        }else{
            $ret = $this->getRedis()->setex($key, $expire, $value);
        }
        return $ret;
    }
       
    /**
     * ������
     *
     * @param string $key ����KEY,֧��һ��ȡ��� $key = array('key1','key2')
     * @return string || boolean  ʧ�ܷ��� false, �ɹ������ַ���
     */
    public function get($key){
        // �Ƿ�һ��ȡ���ֵ
        $func = is_array($key) ? 'mGet' : 'get';
        // û��ʹ��M/S
        if(! $this->_isUseCluster){
            return $this->getRedis()->{$func}($key);
        }
        // ʹ���� M/S
        return $this->_getSlaveRedis()->{$func}($key);
    }
    
 
/*
    // magic function 
    public function __call($name,$arguments){
        return call_user_func($name,$arguments);    
    }
*/
    /**
     * ������ʽ���û��棬��� key ����ʱ�����ã�����ʱ����ʧ��
     *
     * @param string $key ����KEY
     * @param string $value ����ֵ
     * @return boolean
     */
    public function setnx($key, $value){
        return $this->getRedis()->setnx($key, $value);
    }
       
    /**
     * ɾ������
     *
     * @param string || array $key ����KEY��֧�ֵ�����:"key1" ������:array('key1','key2')
     * @return int ɾ���Ľ�������
     */
    public function remove($key){
        // $key => "key1" || array('key1','key2')
        return $this->getRedis()->delete($key);
    }
       
    /**
     * ֵ�ӼӲ���,���� ++$i ,��� key ������ʱ�Զ�����Ϊ 0 ����мӼӲ���
     *
     * @param string $key ����KEY
     * @param int $default ����ʱ��Ĭ��ֵ
     * @return int���������ֵ
     */
    public function incr($key,$default=1){
        if($default == 1){
            return $this->getRedis()->incr($key);
        }else{
            return $this->getRedis()->incrBy($key, $default);
        }
    }
       
    /**
     * ֵ��������,���� --$i ,��� key ������ʱ�Զ�����Ϊ 0 ����м�������
     *
     * @param string $key ����KEY
     * @param int $default ����ʱ��Ĭ��ֵ
     * @return int���������ֵ
     */
    public function decr($key,$default=1){
        if($default == 1){
            return $this->getRedis()->decr($key);
        }else{
            return $this->getRedis()->decrBy($key, $default);
        }
    }
       
    /**
     * ��յ�ǰ���ݿ�
     *
     * @return boolean
     */
    public function clear(){
        return $this->getRedis()->flushDB();
    }
       
    /* =================== ����˽�з��� =================== */
       
    /**
     * ��� HASH �õ� Redis Slave ���������
     *
     * @return redis object
     */
    private function _getSlaveRedis(){
        // ��һ̨ Slave ��ֱ�ӷ���
        if($this->_sn <= 1){
            return $this->_linkHandle['slave'][0];
        }
        // ��� Hash �õ� Slave �ľ��
        $hash = $this->_hashId(mt_rand(), $this->_sn);
        return $this->_linkHandle['slave'][$hash];
    }
       
    /**
     * ����ID�õ� hash �� 0��m-1 ֮���ֵ
     *
     * @param string $id
     * @param int $m
     * @return int
     */
    private function _hashId($id,$m=10)
    {
        //���ַ���Kת��Ϊ 0��m-1 ֮���һ��ֵ��Ϊ��Ӧ��¼��ɢ�е�ַ
        $k = md5($id);
        $l = strlen($k);
        $b = bin2hex($k);
        $h = 0;
        for($i=0;$i<$l;$i++)
        {
            //���ģʽHASH
            $h += substr($b,$i*2,2);
        }
        $hash = ($h*1)%$m;
        return $hash;
    }

    /**
     *    lpush 
     */
    public function lpush($key,$value){
        return $this->getRedis()->lpush($key,$value);
    }

    /**
     *    add lpop
     */
    public function lpop($key){
        return $this->getRedis()->lpop($key);
    }
    /**
     * lrange 
     */
    public function lrange($key,$start,$end){
        return $this->getRedis()->lrange($key,$start,$end);    
    }

    /**
     *    set hash opeation
     */
    public function hset($name,$key,$value){
        if(is_array($value)){
            return $this->getRedis()->hset($name,$key,serialize($value));    
        }
        return $this->getRedis()->hset($name,$key,$value);
    }
    /**
     *    get hash opeation
     */
    public function hget($name,$key = null,$serialize=true){
        if($key){
            $row = $this->getRedis()->hget($name,$key);
            if($row && $serialize){
                unserialize($row);
            }
            return $row;
        }
        return $this->getRedis()->hgetAll($name);
    }

    /**
     *    delete hash opeation
     */
    public function hdel($name,$key = null){
        if($key){
            return $this->getRedis()->hdel($name,$key);
        }
        return $this->getRedis()->hdel($name);
    }
    /**
     * Transaction start
     */
    public function multi(){
        return $this->getRedis()->multi();    
    }
    /**
     * Transaction send
     */

    public function exec(){
        return $this->getRedis()->exec();    
    }
}// End Class








