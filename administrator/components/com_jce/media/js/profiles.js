/*  
 * JCE Editor                 2.2.7.2
 * @package                 JCE
 * @url                     http://www.joomlacontenteditor.net
 * @copyright               Copyright (C) 2006 - 2012 Ryan Demmer. All rights reserved
 * @license                 GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
 * @date                    12 September 2012
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * NOTE : Javascript files have been compressed for speed and can be uncompressed using http://jsbeautifier.org/
 */
(function($){if(typeof Joomla==='undefined'){Joomla={};}
Joomla.submitbutton=submitbutton=function(button){if(button=="cancelEdit"){try{Joomla.submitform(button);}catch(e){submitform(button);}
return;}
if($jce.Profiles.validate()){$jce.Profiles.onSubmit();try{Joomla.submitform(button);}catch(e){submitform(button);}}};$.jce.Profiles={options:{},init:function(options){var self=this;$.extend(true,this.options,options);$('#tabs').tabs();$('input.checkbox-list-toggle-all').click(function(){$('input',this.parentNode.parentNode).prop('checked',this.checked);});$('input[name="components-select"]').click(function(){$('input[type="checkbox"]','#components').prop('disabled',(this.value=='all')).filter(':checked').prop('checked',false);});$('a#users-add').button({icons:{primary:'icon-add'}});$('a#users-remove').button({icons:{primary:'icon-remove'}}).click(function(e){e.preventDefault();$('select#users').children(':selected').remove();return false;});$('a#layout-legend').button({icons:{primary:'icon-legend'}});$("select.editable, select.combobox").combobox(options.combobox);$("#tabs-editor").tabs().addClass('ui-tabs-vertical ui-helper-clearfix');$("#tabs-plugins").tabs({selected:-1}).addClass('ui-tabs-vertical ui-helper-clearfix');var dir=$('body').css('direction')=='rtl'?'right':'left';$("#tabs-editor ul.ui-tabs-nav > li, #tabs-plugins ul.ui-tabs-nav > li").removeClass('ui-corner-top').addClass('ui-corner-'+dir);$("#tabs-plugins").tabs('select',$('ul.ui-tabs-nav > li.ui-state-default:not(.ui-state-disabled):first','#tabs-plugins').index());$('input.color').colorpicker(options.colorpicker);$('select.extensions, input.extensions, textarea.extensions').extensionmapper(options.extensions);this.createLayout();$('select.checklist, input.checklist').checkList();$('input.autocomplete').each(function(){var el=this,v=$(el).attr('placeholder')||'';$(el).removeAttr('placeholder');$(el).autocomplete({source:v.split(',')||[]});});$('#paramseditorwidth').change(function(){var v=$(this).val()||600,s=v+'px';if(/%/.test(v)){s=v,v=600;}else{v=parseInt(v),s=v+'px';}
$('span.widthMarker span','#profileLayoutTable').html(s);$('#editor_container').width(v);$('span.widthMarker, #statusbar_container span.mceStatusbar').width(v);});$('#paramseditorheight').change(function(){var v=$(this).val()||'auto';if(/%/.test(v)){v='auto';}else{if($.type(v)=='number'){v=parseInt(v);}}});$('#paramseditortoolbar_theme').change(function(){var v=$(this).val();if(v.indexOf('.')!=-1){v=v.split('.');var s=v[0]+'Skin';var c=v[1];v=s+' '+s+c.charAt(0).toUpperCase()+c.substring(1);}else{v+='Skin';}
$('span.profileLayoutContainer').each(function(){var cls=this.className;cls=cls.replace(/([a-z0-9]+)Skin([a-z0-9]*)/gi,'');this.className=$.trim(cls);}).addClass(v);});$('#paramseditortoolbar_align').change(function(){var v=$(this).val();$('ul.sortableList','#toolbar_container').removeClass('mceLeft mceCenter mceRight').addClass('mce'+v.charAt(0).toUpperCase()+v.substring(1));self._fixLayout();}).change();$('#paramseditorpath').change(function(){$('span.mceStatusbar span.mcePathLabel').toggle($(this).val()==1);}).change();$('ul#profileAdditionalFeatures input:checkbox').click(function(){self.setPlugins();});$('#paramseditortoolbar_location').change(function(){var $after=$('#editor_container');if($(this).val()=='top'){$after=$('span.widthMarker');}
$('#toolbar_container').insertAfter($after);}).change();$('#paramseditorstatusbar_location').change(function(){var v=$(this).val();$('#statusbar_container').show();if(v=='none'){$('#statusbar_container').hide();}
var $after=$('#editor_container');if(v=='top'){$after=$('span.widthMarker');if($('#paramseditortoolbar_location').val()=='top'){$after=$('#toolbar_container');}}
$('#statusbar_container').insertAfter($after);}).change();$('#paramseditorresizing').change(function(){var v=$(this).val();$('a.mceResize','#statusbar_container').toggle(v==1);}).change();$('#paramseditortoggle').change(function(){var v=$(this).val();$('#editor_toggle').toggle(v==1);}).change();$('#paramseditortoggle_label').on('change keyup',function(){if(this.value){$('#editor_toggle').text(this.value);}});$('#users').click(function(e){var n=e.target;if($(n).is('span.users-list-delete')){$(n).parent().parent().remove();}});},validate:function(){var required=[];$(':input.required').each(function(){if($(this).val()===''){required.push('<li>'+$('label[for="'+this.id+'"]').html()+'</li>');}});if(required.length){var msg='<p>'+$jce.options.labels.required+'</p>';msg+='<ul>';msg+=required.join('');msg+='</ul>';$jce.createDialog({type:'alert',text:msg,modal:true});return false;}
return true;},onSubmit:function(){$('option','#users').prop('selected',true);$('div#tabs-editor, div#tabs-plugins').find(':input[name]').each(function(){if($(this).hasClass('placeholder')){$(this).attr('disabled','disabled');}});},_fixLayout:function(){$('span.mceButton, span.mceSplitButton').removeClass('mceStart mceEnd');$('span.mceListBox').parent('span.sortableRowItem').prev('span.sortableRowItem').children('span.mceButton:last, span.mceSplitButton:last').addClass('mceEnd');$('span.mceListBox').parent('span.sortableRowItem').next('span.sortableRowItem').children('span.mceButton:first, span.mceSplitButton:first').addClass('mceStart');},createLayout:function(){var self=this;$("ul.sortableList").sortable({connectWith:'ul.sortableList',axis:'y',update:function(event,ui){self.setRows();self.setPlugins();},placeholder:'sortableListItem ui-state-highlight'}).disableSelection();$('span.sortableOption').hover(function(){$(this).append('<span role="button"/>');},function(){$(this).empty();}).click(function(){var $parent=$(this).parent();var $target=$('ul.sortableList','#profileLayoutTable').not($parent.parent());$parent.hide().appendTo($target).show('slow');$(this).empty();self.setRows();self.setPlugins();});$('div.sortableRow').sortable({connectWith:'div.sortableRow',tolerance:'pointer',update:function(event,ui){self.setRows();self.setPlugins();self._fixLayout();},start:function(event,ui){$(ui.placeholder).width($(ui.item).width());},placeholder:'sortableRowItem ui-state-highlight'}).disableSelection();if(!$.support.leadingWhitespace){$('.mceSplitButton .mceIcon').not('.mceIconLayer').each(function(){$('<span/>').insertAfter(this);});}else{$('#jce').addClass('multiplebg');}
this._fixLayout();},setRows:function(){var rows=[];$('div.sortableRow:has(span)','#toolbar_container').each(function(){rows.push($.map($('span.sortableRowItem',$(this)),function(el){return $(el).data('name');}).join(','));});$('input[name="rows"]').val(rows.join(';'));},setLayout:function(){var $spans=$('span.profileLayoutContainerCurrent > span').not('span.widthMarker');$.each(['toolbar','editor','statusbar'],function(){$('#paramseditor'+this+'_location').val($spans.index($('#'+this+'_container')));});},setPlugins:function(){var self=this,plugins=[];$('div.sortableRow span.plugin','#toolbar_container').each(function(){plugins.push($(this).data('name'));});$('ul#profileAdditionalFeatures input:checkbox:checked').each(function(){plugins.push($(this).val());});$('input[name="plugins"]').val(plugins.join(','));this.setParams(plugins);},setParams:function(plugins){var $tabs=$('div#tabs-plugins');$('div.ui-tabs-panel','div#tabs-plugins').each(function(i){var name=$(this).data('name');var s=$.inArray(name,plugins)!=-1;$(':input[name]',$(this)).prop('disabled',!s);if(!s){if($tabs.tabs('option','selected')==i){var n=0,x=$tabs.tabs('option','disabled');while(i==n){n++;if($.inArray(n,x)!=-1){n++;}}
$tabs.tabs('select',n);}
$tabs.tabs('disable',i);}else{$tabs.tabs('enable',i);}});}};})(jQuery);