KISSY.use("node,anim,event", function(S, Node, Anim, Event) {

	var af_actindex = 0;
	var af_click = true;
	var af_timer = null;
	var af_outer = null;
	af_timer = setInterval(function() {
		af_actindex += 1;
		if (af_actindex > 12) {
			af_actindex = 0
		};
		S.one("#af_player_in").stop(true)
		S.one("#af_player_in").animate({
			"left": -816 * af_actindex
		}, {
			easing: 'ease',
			duration: 0.4,
			useTransition: true,
			complete: function() {
				af_click = true;
			}
		});
	}, 3000);
	S.one("#af_player_con").on("mouseout", function() {
		clearInterval(af_timer);
		clearTimeout(af_outer);
		af_outer = setTimeout(function() {
			
			af_timer = setInterval(function() {
				af_actindex += 1;
				if (af_actindex > 12) {
					af_actindex = 0
				};
				S.one("#af_player_in").stop(true)
				S.one("#af_player_in").animate({
					"left": -816 * af_actindex
				}, {
					easing: 'ease',
					duration: 0.4,
					useTransition: true,
					complete: function() {
						af_click = true;
					}
				});
			}, 3000);
		}, 5000);
	})
	S.one("#af_l").on("click", function() {
		clearInterval(af_timer);
		clearTimeout(af_outer);
		if (!af_click) {
			return false;
		}
		af_actindex -= 1;
		af_click = false;
		if (af_actindex < 0) {
			af_actindex = 12
		};
		S.one("#af_player_in").stop(true)
		S.one("#af_player_in").animate({
			"left": -816 * af_actindex
		}, {
			easing: 'ease',
			duration: 0.4,
			useTransition: true,
			complete: function() {
				af_click = true;
			}
		});
	});
	S.one("#af_r").on("click", function() {
		clearInterval(af_timer);
		clearTimeout(af_outer);
		if (!af_click) {
			return false;
		}
		af_actindex += 1;
		af_click = false;
		if (af_actindex > 12) {
			af_actindex = 0
		};
		S.one("#af_player_in").stop(true)
		S.one("#af_player_in").animate({
			"left": -816 * af_actindex
		}, {
			easing: 'ease',
			duration: 0.4,
			useTransition: true,
			complete: function() {
				af_click = true;
			}
		});
	});
});