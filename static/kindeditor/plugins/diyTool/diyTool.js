KindEditor.plugin('diyTool', function (K) {
	var self = this, name = 'diyTool';

	self.plugin.diyTool = {
		edit : function() {
			art.dialog.data('editer', self);
			// 此时 iframeA.html 页面可以使用 art.dialog.data('test') 获取到数据，如：
			// document.getElementById('aInput').value = art.dialog.data('test');
			art.dialog.open(diyTool,{lock:false,title:'自定义图文素材',width:600,height:400,yesText:'关闭',background: '#000',opacity: 0.87});


		},
		'delete' : function() {
	
			
		}
	};
	self.clickToolbar(name, self.plugin.diyTool.edit);
});