var g = "20150313162800";  
var p = "106025087133488299239129351247929016326438167258746469805890028339770628303789813787064911279666129";  
	       
var big_a = randBigInt(100);
var big_p = str2bigInt(p, 10, 0);
var big_g = str2bigInt(g, 10, 0);

var A = powMod(big_g, big_a, big_p);
var str_A = bigInt2str(A, 10);

var B;
var secret;

$.ajax({
	url:  '../../data/secre.php',
	type: 'GET',
	async: false,
	data: {act:"secret", "A":str_A},
	cache: false,
	dataType: 'json',
	success: function(data) {
		B = str2bigInt(data.B, 10, 0);
	}
});
secret = powMod(B, big_a, big_p);
secret = bigInt2str(secret, 10);