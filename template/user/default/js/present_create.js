$(function(){
	load_page('.app__content',load_url,{page: page_create},'');

});
function msg_hide() {
	$('.notifications').html('');
	clearTimeout(t);
}