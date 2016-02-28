//
// Helper for run TinyMCE editor with textarea's
//
function TinyMCEStart(elem, mode){
	var plugins = [];
	if (mode == 'extreme'){
		plugins = [ "advlist anchor autolink autoresize autosave bbcode charmap code contextmenu directionality ",
			"emoticons fullpage fullscreen hr image insertdatetime layer legacyoutput",
			"link lists media nonbreaking noneditable pagebreak paste preview print save searchreplace",
			"tabfocus table template textcolor visualblocks visualchars wordcount"]
	}
	tinymce.init({selector: elem,
		theme: "modern",
		plugins: plugins,
		//content_css: "css/style.css",
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
		style_formats: [
			{title: 'Header 2', block: 'h2', classes: 'page-header'},
			{title: 'Header 3', block: 'h3', classes: 'page-header'},
			{title: 'Header 4', block: 'h4', classes: 'page-header'},
			{title: 'Header 5', block: 'h5', classes: 'page-header'},
			{title: 'Header 6', block: 'h6', classes: 'page-header'},
			{title: 'Bold text', inline: 'b'},
			{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
			{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
			{title: 'Example 1', inline: 'span', classes: 'example1'},
			{title: 'Example 2', inline: 'span', classes: 'example2'},
			{title: 'Table styles'},
			{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
		]
	});
}
$(document).ready(function () { 
TinyMCEStart('#wysiwig_simple', null);
		$("#auctiontype").change(function(){
            $("#auctiontype option:selected").each(function(){
                if($(this).attr("value")=="auction"){
                    $(".buyitnow").hide();
                    $(".auctioninfo").show();
                }
                if($(this).attr("value")=="buyitnow"){
                    $(".auctioninfo").hide();
                    $(".buyitnow").show();
                }          
				});
        }).change();
		
		$('#international').on('change', function () {
			if (this.checked) {
			 $('#posticon').addClass('fa-plane').removeClass('fa-truck');
			$("#internationalprice").show();
			}
		});
		$('#localpost').on('change', function () {
			if (this.checked) {
			$('#posticon').addClass('fa-truck').removeClass('fa-plane');
			$("#internationalprice").hide();
			}
		});
    });
	   var edit = function() {
            $('.click2edit').summernote({focus: true});
        };
        var save = function() {
            var aHTML = $('.click2edit').code(); //save HTML If you need(aHTML: array).
            $('.click2edit').destroy();
        };
		
		    $(document).ready(function ()
    {
        $("#wizard").steps();
        $("#form").steps(
                {
                    bodyTag: "fieldset",
                    onStepChanging: function (event, currentIndex, newIndex)
                    {
                        // Always allow going backward even if the current step contains invalid fields!
                        if (currentIndex > newIndex)
                        {
                            return true;
                        }
                        var form = $(this);
                        // Clean up if user went backward before
                        if (currentIndex < newIndex)
                        {
                            // To remove error styles
                            $(".body:eq(" + newIndex + ") label.error", form).remove();
                            $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                        }
                        // Disable validation on fields that are disabled or hidden.
                        form.validate().settings.ignore = ":disabled,:hidden";
                        // Start validation; Prevent going forward if false
                        return form.valid();
                    },
                    onStepChanged: function (event, currentIndex, priorIndex)
                    {
                        // Suppress (skip) "Warning" step if the user is old enough.
                        if (currentIndex === 2)
                        {
                            $(this).steps("next");
                        }
                        // Suppress (skip)
                        if (currentIndex === 2 && priorIndex === 3)
                        {
                            $(this).steps("previous");
                        }
                    },
                    onFinishing: function (event, currentIndex)
                    {
                        var form = $(this);
                        // Disable validation on fields that are disabled.
                        // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                        form.validate().settings.ignore = ":disabled";
                        // Start validation; Prevent form submission if false
                        return form.valid();
                    },
                    onFinished: function (event, currentIndex)
                    {
                        var form = $(this);
                        // Submit form input
                        form.submit();
                    }
                })
    });
	
	
	  $(document).ready(function () {
            $('input#producttitle').maxlength({
				alwaysShow: true,
                threshold: 100,
				warningClass: "label label-success",
                limitReachedClass: "label label-danger",
				placement: 'top-right'
            });		

            $('input#aboutme').maxlength({
				alwaysShow: true,
                threshold: 150,
				warningClass: "label label-success",
                limitReachedClass: "label label-danger",
				placement: 'top-right'
            });

            $('input#firstname').maxlength({
				alwaysShow: true,
                threshold: 100,
				warningClass: "label label-success",
                limitReachedClass: "label label-danger",
				placement: 'top-right'
            });
            $('input#lastname').maxlength({
				alwaysShow: true,
                threshold: 100,
				warningClass: "label label-success",
                limitReachedClass: "label label-danger",
				placement: 'top-right'
            });
            $('input#address1').maxlength({
				alwaysShow: true,
                threshold: 100,
				warningClass: "label label-success",
                limitReachedClass: "label label-danger",
				placement: 'top-right'
            });	
            $('input#address2').maxlength({
				alwaysShow: true,
                threshold: 100,
				warningClass: "label label-success",
                limitReachedClass: "label label-danger",
				placement: 'top-right'
            });	
            $('input#city').maxlength({
				alwaysShow: true,
                threshold: 100,
				warningClass: "label label-success",
                limitReachedClass: "label label-danger",
				placement: 'top-right'
            });	
            $('input#state').maxlength({
				alwaysShow: true,
                threshold: 100,
				warningClass: "label label-success",
                limitReachedClass: "label label-danger",
				placement: 'top-right'
            });	
            $('input#country').maxlength({
				alwaysShow: true,
                threshold: 100,
				warningClass: "label label-success",
                limitReachedClass: "label label-danger",
				placement: 'top-right'
            });	
            $('input#zipcode').maxlength({
				alwaysShow: true,
                threshold: 100,
				warningClass: "label label-success",
                limitReachedClass: "label label-danger",
				placement: 'top-right'
            });	
            $('input#feedback').maxlength({
				alwaysShow: true,
                threshold: 150,
				warningClass: "label label-success",
                limitReachedClass: "label label-danger",
				placement: 'top-right'
            });	
            $('input#country').maxlength({
				alwaysShow: true,
                threshold: 100,
				warningClass: "label label-success",
                limitReachedClass: "label label-danger",
				placement: 'top-right'
            });				
			$('input#shortdescription').maxlength({
				alwaysShow: true,
                threshold: 100,
				warningClass: "label label-success",
                limitReachedClass: "label label-danger",
				placement: 'top-right'
            });
			
            

        });