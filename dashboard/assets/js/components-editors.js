var ComponentsEditors = function () {
    
   
    var handleWysihtml5 = function () {
        if (!jQuery().wysihtml5) {
            return;
        }

        if ($('.wysihtml5').size() > 0) {
            $('.wysihtml5').wysihtml5({
                "stylesheets": ["../../assets/global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
            });
        }
    }

    var handleSummernote = function () {
        $('#summernote_1').summernote({
            height: 180,
            onpaste: function(e) {
                var thisNote = $(this);
                var updatePastedText = function(someNote){
                    var original = someNote.code();
                    var cleaned = CleanPastedHTML(original); //this is where to call whatever clean function you want. I have mine in a different file, called CleanPastedHTML.
                    someNote.code('').html(cleaned); //this sets the displayed content editor to the cleaned pasted code.
                };
                setTimeout(function () {
                    //this kinda sucks, but if you don't do a setTimeout, 
                    //the function is called before the text is really pasted.
                    updatePastedText(thisNote);
                }, 10);
            }
        });
        $('#termsField').summernote({
            height: 180,
            onpaste: function(e) {
                var thisNote = $(this);
                var updatePastedText = function(someNote){
                    var original = someNote.code();
                    var cleaned = CleanPastedHTML(original); //this is where to call whatever clean function you want. I have mine in a different file, called CleanPastedHTML.
                    someNote.code('').html(cleaned); //this sets the displayed content editor to the cleaned pasted code.
                };
                setTimeout(function () {
                    //this kinda sucks, but if you don't do a setTimeout, 
                    //the function is called before the text is really pasted.
                    updatePastedText(thisNote);
                }, 10);
            }
        });
        $('#descriptionField').summernote({
            height: 180,
            onpaste: function(e) {
                var thisNote = $(this);
                var updatePastedText = function(someNote){
                    var original = someNote.code();
                    var cleaned = CleanPastedHTML(original); //this is where to call whatever clean function you want. I have mine in a different file, called CleanPastedHTML.
                    someNote.code('').html(cleaned); //this sets the displayed content editor to the cleaned pasted code.
                };
                setTimeout(function () {
                    //this kinda sucks, but if you don't do a setTimeout, 
                    //the function is called before the text is really pasted.
                    updatePastedText(thisNote);
                }, 10);
            }
        });
        $('#postDescField').summernote({
            height: 180,
            onpaste: function(e) {
                var thisNote = $(this);
                var updatePastedText = function(someNote){
                    var original = someNote.code();
                    var cleaned = CleanPastedHTML(original); //this is where to call whatever clean function you want. I have mine in a different file, called CleanPastedHTML.
                    someNote.code('').html(cleaned); //this sets the displayed content editor to the cleaned pasted code.
                };
                setTimeout(function () {
                    //this kinda sucks, but if you don't do a setTimeout, 
                    //the function is called before the text is really pasted.
                    updatePastedText(thisNote);
                }, 10);
            }
        });
        $('#serviceDescField').summernote({
            height: 180,
            onpaste: function(e) {
                var thisNote = $(this);
                var updatePastedText = function(someNote){
                    var original = someNote.code();
                    var cleaned = CleanPastedHTML(original); //this is where to call whatever clean function you want. I have mine in a different file, called CleanPastedHTML.
                    someNote.code('').html(cleaned); //this sets the displayed content editor to the cleaned pasted code.
                };
                setTimeout(function () {
                    //this kinda sucks, but if you don't do a setTimeout, 
                    //the function is called before the text is really pasted.
                    updatePastedText(thisNote);
                }, 10);
            }
        });


         $('#aboutField').summernote({
            height: 180,
            onpaste: function(e) {
                var thisNote = $(this);
                var updatePastedText = function(someNote){
                    var original = someNote.code();
                    var cleaned = CleanPastedHTML(original); //this is where to call whatever clean function you want. I have mine in a different file, called CleanPastedHTML.
                    someNote.code('').html(cleaned); //this sets the displayed content editor to the cleaned pasted code.
                };
                setTimeout(function () {
                    //this kinda sucks, but if you don't do a setTimeout, 
                    //the function is called before the text is really pasted.
                    updatePastedText(thisNote);
                }, 10);
            }
        });

        // edit
        //$('#editserviceDescField').summernote({ height: 180, disableDragAndDrop: true });
        //API:
        //var sHTML = $('#summernote_1').code(); // get code
        //$('#summernote_1').destroy(); // destroy
    }

    return {
        //main function to initiate the module
        init: function () {
            handleWysihtml5();
            handleSummernote();
        }
    };

}();


function CleanPastedHTML(input) {
  // 1. remove line breaks / Mso classes
  var stringStripper = /(\n|\r| class=(")?Mso[a-zA-Z]+(")?)/g;
  var output = input.replace(stringStripper, ' ');
  // 2. strip Word generated HTML comments
  var commentSripper = new RegExp('<!--(.*?)-->','g');
  var output = output.replace(commentSripper, '');
  var tagStripper = new RegExp('<(/)*(meta|link|span|\\?xml:|st1:|o:|font)(.*?)>','gi');
  // 3. remove tags leave content if any
  output = output.replace(tagStripper, '');
  // 4. Remove everything in between and including tags '<style(.)style(.)>'
  var badTags = ['style', 'script','applet','embed','noframes','noscript'];

  for (var i=0; i< badTags.length; i++) {
    tagStripper = new RegExp('<'+badTags[i]+'.*?'+badTags[i]+'(.*?)>', 'gi');
    output = output.replace(tagStripper, '');
  }
  // 5. remove attributes ' style="..."'
  var badAttributes = ['style', 'start'];
  for (var i=0; i< badAttributes.length; i++) {
    var attributeStripper = new RegExp(' ' + badAttributes[i] + '="(.*?)"','gi');
    output = output.replace(attributeStripper, '');
  }
  return output;
}