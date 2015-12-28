/**
 * Created by Alex on 14.11.13.
 */
$(function () {
    $('.userInfo a:first-child').tooltip();
    $('[rel=tooltip]').tooltip();
    $("#authButtonHeader").popover({
        content: $("#loginPopover").html(),
        placement: "bottom",
        html: true
    });
    $(".blockEdit").keypress(function(e){
        e.preventDefault();
    }).keydown(function(e){
            e.preventDefault();
        });
    $('.datepickerObj').datepicker();
});