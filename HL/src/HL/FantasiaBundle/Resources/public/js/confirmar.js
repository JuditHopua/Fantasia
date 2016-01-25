function confirmar () {
	$( "#dialog" ).dialog({
	     
		resizable: false,
        height:140,
        modal: true,
        buttons: {
            'Confirm submit': function() {
                document.getElementsByName("hl_fantasiabundle_cliente").submit();
            },
            Cancel: function() {
                $(this).dialog('close');
            }
        }
    });
}


$('.allForms').submit(function(){
      $('#dialog').dialog('open');
});