$(function() {
    // listen click, open modal and load content
   $(document).on('click', '#modalButton', function(e){
        var $this = $(this);
        var current_title = $this.attr('title');
        var href = $(this).attr('value');
        $.get(href, function (data) {
            $('#site-modal-content').html(data);
            $('#site-modal').modal().find('.modal-header').html('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="gridSystemModalLabel">'+current_title+'</h4>');
        });
    });

    $(document).on("pjax:timeout", function(event) {
        // Prevent default timeout redirection behavior
        event.preventDefault()
    });

    $(document).on('click', '.pjax-grid-action', function(e){
        e.preventDefault();
        var $this = $(this);
        var current_title = $this.attr('title');
        var href = $(this).attr('href');
        $.get(href, function (data) {
            $('#site-modal-content').html(data);
            $('#site-modal').modal().find('.modal-header').html('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="gridSystemModalLabel">'+current_title+'</h4>');
        });
        return false;
    });

    $('body').on('click', '.grid-delete-action', function(e){ 
            var href = $(this).attr('href');
            var self = this; 

             var record = bootbox.confirm("Сигурни ли сте, че искате да изтриете този елемент?", function (res) {
                 if (res == true) {
                    $.post(href, function(){
                        var pjax_id = $(self).closest('.pjax-wrapper').attr('id');
                        $.pjax.reload({container:'#' + pjax_id});
                    });
                }
             });
            return false;
    });

});
 
// serialize form, render response and close modal
function submitForm($form) {
    $.post(
        $form.attr("action"),
        $form.serialize()
    )
        .done(function(result) {
            $form.parent().html(result.message);
            $('#site-modal').modal('hide');
        })
        .fail(function() {
            console.log("server error");
        });
    return false;
}




