(function(){
	jQuery(document).load(function(){
   jQuery("a[href$='"+location.hash.slice(1)+"']").click()
	});
})();