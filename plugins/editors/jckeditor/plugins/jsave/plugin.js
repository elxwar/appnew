﻿(function(){function b(a){var b=[],c=new RegExp("\\b"+a+"\\b"),d=CKEDITOR.document.$;var e=d.getElementsByTagName("*");for(var f=0;f<e.length;f++){var g=e[f].className;if(c.test(g)){b.push(e[f]);break}}return(new CKEDITOR.dom.nodeList(b)).getItem(0)}function w(f){if(f){if(f.getChildCount()){var g=f.getChildren();for(var d=0;d<g.count();d++){var child=g.getItem(d);if(child.type!=CKEDITOR.NODE_TEXT&&(child.getName()=="a"||child.getName()=="button")){var action=child.getAttribute("onclick");if(action&&action.toString().match(/submitbutton\('(.*)'\)/)){action=RegExp.$1;return action}}else if(child.type==CKEDITOR.NODE_ELEMENT){return w(child)}}}return false}else return false}var a=CKEDITOR.document.getWindow();var c=["toolbar-apply","toolbar-save","save","formelm-buttons","btn-toolbar"];var e="",action=false;for(var d=0;d<c.length;d++){e=c[d],f=CKEDITOR.document.getById(e)||b(e);action=w(f);if(action)break;e=""}var h={modes:{wysiwyg:1,source:1},exec:function(b){if(a.$.submitbutton)a.$.submitbutton(action);else if(Joomla&&Joomla.submitbutton)Joomla.submitbutton(action)}};var i="save";CKEDITOR.plugins.add("jsave",{init:function(b){var c=b.addCommand(i,h);c.modes={wysiwyg:!!(a.$.submitbutton||Joomla&&Joomla.submitbutton)};if(e){b.ui.addButton("Save",{label:b.lang.save,command:i})}}})})()