$(function(){	
	
	$(".Div1_main div span").mouseover(function(){
		$(this).addClass("Div1_main_span1").siblings("span").removeClass("Div1_main_span1");
	}).mouseout(function(){
		$(this).removeClass("Div1_main_span1").siblings("span");
	})
	
	
	var 
		 index = 0 ;
		Swidth = 750 ;
		 timer = null ;
		   len = $(".Div1_title span a").length ; 
		
		function NextPage(iii)
		{		
			if(index>2)
			{
				index = 0 ;
			}
			if(iii || 0===iii) {
				$(".Div1_title span a").eq(iii).removeClass("Div1_title_a1").addClass("Div1_title_a1");
				$(".Div1_main").eq(iii).stop(true, false).animate({left: -index*Swidth+"px"},600)						
			} else{
					$(".Div1_title span a").removeClass("Div1_title_a1").addClass("Div1_title_a1");
				$(".Div1_main").stop(true, false).animate({left: -index*Swidth+"px"},600)					
				
			}

		}
		
		function PrevPage(iii)
		{	
			if(index<0)
			{
				index = 2 ;
			}
			if(iii || 0===iii) {
				$(".Div1_title span a").eq(iii).removeClass("Div1_title_a1").addClass("Div1_title_a1");
				$(".Div1_main").eq(iii).stop(true, false).animate({left: -index*Swidth+"px"},600)		
			} else {
				$(".Div1_title span a").removeClass("Div1_title_a1").addClass("Div1_title_a1");
				$(".Div1_main").stop(true, false).animate({left: -index*Swidth+"px"},600)			
			}	
		}
		
		$(".Div1_title span a").each(function(a){
            $(this).mouseover(function(){
				index = a ;
				NextPage();
			});
        });
		//下一页
		$(".Div1_next img").click(function(){
			var div2_index = $(".Div1_next img").index($(this));
			 index++ ;
			 NextPage(div2_index);
		});
		//上一页
		$(".Div1_prev img").click(function(){
			
			var div1_index = $(".Div1_prev img").index($(this));
			 index-- ;
			 PrevPage(div1_index);
		});
		//自动滚动
		var timer = setInterval(function(){
				index++ ;
				NextPage();
			},4000);
			
		$(".Div1_next img , .Div1_main , .Div1_prev img , .Div1_title span").mouseover(function(){
			clearInterval(timer);
		});
		$(".Div1_next img , .Div1_main , .Div1_prev img , .Div1_title span").mouseleave(function(){
			timer = setInterval(function(){
				index++ ;
				NextPage();
			},4000);	
		});
			
})//建站套餐
