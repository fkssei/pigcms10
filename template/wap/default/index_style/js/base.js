var motify = {
	timer:null,
	log:function(msg,time){
		$('.motify').hide();
		if(motify.timer) clearTimeout(motify.timer);
		if($('.motify').size() > 0){
			$('.motify').show().find('.motify-inner').html(msg);
		}else{
			$('body').append('<div class="motify" style="display:block;"><div class="motify-inner">'+msg+'</div></div>');
		}
		if(!time && time != 0) time=3000;
		if(time > 0){
			motify.timer = setTimeout(function(){
				$('.motify').hide();
			},3000);
		}
	},
	checkMobile:function(){
		if(/(iphone|ipad|ipod|android|windows phone)/.test(navigator.userAgent.toLowerCase())){
			return true;
		}else{
			return false;
		}
	}
};