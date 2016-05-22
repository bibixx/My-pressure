/*
  * jQuery printPage Plugin
  * @version: 1.0
  * @author: Cedric Dugas, http://www.position-absolute.com
  * @licence: MIT
  * @desciption: jQuery page print plugin help you print your page in a better way
*/

(function( $ ){
  $.fn.printPage = function(options) {
    // EXTEND options for this button
    var pluginOptions = {
      attr : "href",
      url : false,
      message: "Please wait while we create your document"
    };
    $.extend(pluginOptions, options);

    /*
      * Call iframe
      * @param {jQuery} el - The button calling the plugin
      * @param {Object} pluginOptions - options for this print button
    */

    this.on("click", function(){ addIframeToPage(this, pluginOptions); return false;  });

    /*
      * Inject iframe into document and attempt to hide, it, can't use display:none
      * You can't print if the element is not dsplayed
      * @param {jQuery} el - The button calling the plugin
      * @param {Object} pluginOptions - options for this print button
    */

    function addIframeToPage(el, pluginOptions){

        var url = (pluginOptions.url) ? pluginOptions.url : $(el).attr(pluginOptions.attr);

        if(!$('#printPage')[0]){
          $("body").append(components.iframe(url));
          $('#printPage').on("load",function() {  printit();  })
        }else{
          $('#printPage').attr("src", url);
        }
    }

    /*
      * Call the print browser functionnality, focus is needed for IE
    */

    function printit(){
      frames["printPage"].focus();
      frames["printPage"].print();
    }

    /*
      * Build html compononents for thois plugin
    */

    var components = {
      iframe: function(url){
        return '<iframe id="printPage" name="printPage" src='+url+' style="position:absolute;top:0px; left:0px;width:0px; height:0px;border:0px;overfow:none; z-index:-1"></iframe>';
      }
    }
  };
})( jQuery );
