
;(function($,window){
	

	var exportsMethods = {
	

		newVerScrollForPull : function(wrapper,pulldownAction,pullupAction,opts,pullText){
			
			var $wrapper ;
			if(typeof wrapper === 'string'){
				$wrapper = $(wrapper);
			}else if(typeof wrapper === 'object'){
				$wrapper = wrapper;
			}
			
			var pulldownRefresh   = pullText && pullText['pulldownRefresh'] ? pullText['pulldownRefresh'] : '',
				pullupLoadingMore = pullText && pullText['pullupLoadingMore'] ? pullText['pullupLoadingMore'] : '',
				releaseToRefresh  = pullText && pullText['releaseToRefresh'] ? pullText['releaseToRefresh'] : '松手开始刷新...',
				releaseToLoading  = pullText && pullText['releaseToLoading'] ? pullText['releaseToLoading'] : '松手开始加载...',
				loading 		  = pullText && pullText['loading'] ? pullText['loading'] : '加载中...';
			
			var $pulldown = $wrapper.find('#pulldown'),
				$pullup   = $wrapper.find('#pullup'),
				pullupOffset   = 0,
				pulldownOffset = 0;
			
			if($pulldown.length>0){
				pulldownOffset = $pulldown.outerHeight();
				$pulldown.find('#pulldown-label').html(pulldownRefresh);
			}
			
			if($pullup.length>0){
				pullupOffset = $pullup.outerHeight();
				$pullup.find('#pullup-label').html(pullupLoadingMore);
			}
			

			var options = {
				topOffset : pulldownOffset
			};
			
			$.extend(true,options,opts);
			
			var scrollObj = this.newVerScroll($wrapper[0],options);
			

			scrollObj.on('refresh',function(){
				
				var $pulldown = $wrapper.find('#pulldown'),
					$pullup   = $wrapper.find('#pullup');
				
				if ($pulldown.length>0 && $pulldown.hasClass('loading')) {
				    $pulldown.removeClass().addClass('idle');
					$pulldown.find('#pulldown-label').html(pulldownRefresh);
				} else if ($pullup.length>0){
					$pullup.find('#pullup-icon').show();
					if($pullup.hasClass('loading')){
						$pullup.find('#pullup-icon').show();
						$pullup.removeClass().addClass('idle');
						$pullup.find('#pullup-label').html(pullupLoadingMore);
					}
				}
			});
			

			scrollObj.on('scrollMove',function(){
				
				var $pulldown = $wrapper.find('#pulldown'),
					$pullup   = $wrapper.find('#pullup');
					
				if ($pulldown.length>0 && this.y > 5 && !$pulldown.hasClass('flip')) {
					$pulldown.removeClass().addClass('flip');
					$pulldown.find('#pulldown-label').html(releaseToRefresh);
					this.minScrollY = 0;
					
				} else if ($pulldown.length>0 && this.y < 5 && $pulldown.hasClass('flip')) {
				    $pulldown.removeClass().addClass('idle');;
					$pulldown.find('#pulldown-label').html(pulldownRefresh);
					this.minScrollY = -pulldownOffset;
				//this.y < this.minScrollY代表是上拉,以防下拉的时候未拉到尽头时进入上拉的逻辑中
				} else if ($pullup.length>0 && this.y < this.minScrollY && this.y < (this.maxScrollY - 5) && !$pullup.hasClass('flip')) {
					$pullup.removeClass().addClass('flip');
					$pullup.find('#pullup-label').html(releaseToLoading);
					this.maxScrollY = this.maxScrollY;
					
				} else if ($pullup.length>0 && (this.y > (this.maxScrollY + 5)) && $pullup.hasClass('flip')) {
				    $pullup.removeClass().addClass('idle');
					$pullup.find('#pullup-label').html(pullupLoadingMore);
					this.maxScrollY = pullupOffset;
				}
			});
			

			scrollObj.on('scrollEnd',function(){
				
				var $pulldown = $wrapper.find('#pulldown'),
					$pullup   = $wrapper.find('#pullup');
					
				if ($pulldown.length>0 && $pulldown.hasClass('flip')) {
					$pulldown.removeClass().addClass('loading');
					$pulldown.find('#pulldown-label').html(loading);
					if(typeof pulldownAction === 'function'){
						pulldownAction.call(scrollObj);	
					}
				} else if ($pullup.length>0 && $pullup.hasClass('flip')) {
					$pullup.removeClass().addClass('loading');
					$pullup.find('#pullup-label').html(loading);
					if(typeof pullupAction === 'function' && $pullup.parent().length>0){
						pullupAction.call(scrollObj);
					}				
				}
			});
			
			return scrollObj;
		},

		newVerScroll : function(dom,option){
			var opt = {
				scrollbars : true, //是否有滚动条
				useTransition: false
			};
			if(option){
				$.extend(opt,option);
			}
			var iSObj = new IScroll(dom,opt);
			

			iSObj.on("scrollEnd",function(){
				if(this.indicator1){
					this.indicator1.indicatorStyle['transition-duration'] = '350ms';
					this.indicator1.indicatorStyle['opacity'] = '0';
				}
			});
			iSObj.on("scrollMove",function(){
				if(this.indicator1){
					this.indicator1.indicatorStyle['transition-duration'] = '0ms';
					this.indicator1.indicatorStyle['opacity'] = '0.8';
				}
			});
			return iSObj;
		}
	};
	
	window.iscrollAssist = exportsMethods;
	
})(jQuery,window);
function jumpproduct(id) {

}
function jumpaspx(url){
      window.location.href = url;
}
