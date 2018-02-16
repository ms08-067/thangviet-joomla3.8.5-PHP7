(function($){"use strict";$.subformRepeatable=function(container,options){this.$container=$(container);if(this.$container.data("subformRepeatable")){return self}this.$container.data("subformRepeatable",self);this.options=$.extend({},$.subformRepeatable.defaults,options);this.template="";this.prepareTemplate();this.$containerRows=this.options.rowsContainer?this.$container.find(this.options.rowsContainer):this.$container;this.lastRowNum=this.$containerRows.find(this.options.repeatableElement).length;var self=this;this.$container.on("click",this.options.btAdd,function(e){e.preventDefault();var after=$(this).parents(self.options.repeatableElement);if(!after.length){after=null}self.addRow(after)});this.$container.on("click",this.options.btRemove,function(e){e.preventDefault();var $row=$(this).parents(self.options.repeatableElement);self.removeRow($row)});if(this.options.btMove){this.$containerRows.sortable({items:this.options.repeatableElement,handle:this.options.btMove,tolerance:"pointer"})}this.$container.trigger("subform-ready")};$.subformRepeatable.prototype.prepareTemplate=function(){if(this.options.rowTemplateSelector){var tmplElement=this.$container.find(this.options.rowTemplateSelector)[0]||{};this.template=$.trim(tmplElement.text||tmplElement.textContent)}else{var row=this.$container.find(this.options.repeatableElement).get(0),$row=$(row).clone();try{this.clearScripts($row)}catch(e){if(window.console){console.log(e)}}this.template=$row.prop("outerHTML")}};$.subformRepeatable.prototype.addRow=function(after){var count=this.$containerRows.find(this.options.repeatableElement).length;if(count>=this.options.maximum){return null}var row=$.parseHTML(this.template);if(after){$(after).after(row)}else{this.$containerRows.append(row)}var $row=$(row);$row.attr("data-new","true");this.fixUniqueAttributes($row,count);try{this.fixScripts($row)}catch(e){if(window.console){console.log(e)}}this.$container.trigger("subform-row-add",$row);return $row};$.subformRepeatable.prototype.removeRow=function($row){var count=this.$containerRows.find(this.options.repeatableElement).length;if(count<=this.options.minimum){return}this.$container.trigger("subform-row-remove",$row);$row.remove()};$.subformRepeatable.prototype.fixUniqueAttributes=function($row,count){this.lastRowNum++;var group=$row.attr("data-group"),basename=$row.attr("data-base-name"),count=count||0,countnew=Math.max(this.lastRowNum,count+1),groupnew=basename+countnew;this.lastRowNum=countnew;$row.attr("data-group",groupnew);var haveName=$row.find("[name]"),ids={};for(var i=0,l=haveName.length;i<l;i++){var $el=$(haveName[i]),name=$el.attr("name"),id=name.replace(/(\[\]$)/g,"").replace(/(\]\[)/g,"__").replace(/\[/g,"_").replace(/\]/g,""),nameNew=name.replace("["+group+"][","["+groupnew+"]["),idNew=id.replace(group,groupnew),countMulti=0,forOldAttr=id;if($el.prop("type")==="checkbox"&&name.match(/\[\]$/)){countMulti=ids[id]?ids[id].length:0;if(!countMulti){$el.closest("fieldset.checkboxes").attr("id",idNew);$row.find('label[for="'+id+'"]').attr("for",idNew).attr("id",idNew+"-lbl")}forOldAttr=forOldAttr+countMulti;idNew=idNew+countMulti}else if($el.prop("type")==="radio"){countMulti=ids[id]?ids[id].length:0;if(!countMulti){$el.closest("fieldset.radio").attr("id",idNew);$row.find('label[for="'+id+'"]').attr("for",idNew).attr("id",idNew+"-lbl")}forOldAttr=forOldAttr+countMulti;idNew=idNew+countMulti}if(ids[id]){ids[id].push(true)}else{ids[id]=[true]}$el.attr("name",nameNew);$el.attr("id",idNew);$row.find('label[for="'+forOldAttr+'"]').attr("for",idNew).attr("id",idNew+"-lbl")}};$.subformRepeatable.prototype.clearScripts=function($row){if($.fn.chosen){$row.find("select.chzn-done").each(function(){var $el=$(this);$el.next(".chzn-container").remove();$el.show().addClass("fix-chosen")})}};$.subformRepeatable.prototype.fixScripts=function($row){$row.find('a[onclick*="jInsertFieldValue"]').each(function(){var $el=$(this),inputId=$el.siblings('input[type="text"]').attr("id"),$select=$el.prev(),oldHref=$select.attr("href");$el.attr("onclick","jInsertFieldValue('', '"+inputId+"');return false;");$select.attr("href",oldHref.replace(/&fieldid=(.+)&/,"&fieldid="+inputId+"&"))});if($.fn.fieldMedia){$row.find(".field-media-wrapper").fieldMedia()}if($.fn.tooltip){$row.find(".hasTooltip").tooltip({html:true,container:"body"})}if($.fn.fieldUser){$row.find(".field-user-wrapper").fieldUser()}if(window.SqueezeBox&&window.SqueezeBox.assign){SqueezeBox.assign($row.find("a.modal").get(),{parse:"rel"})}};$.subformRepeatable.defaults={btAdd:".group-add",btRemove:".group-remove",btMove:".group-move",minimum:0,maximum:10,repeatableElement:".subform-repeatable-group",rowTemplateSelector:"script.subform-repeatable-template-section",rowsContainer:null};$.fn.subformRepeatable=function(options){return this.each(function(){var options=options||{},data=$(this).data();if(data.subformRepeatable){return}for(var p in data){if(data.hasOwnProperty(p)){options[p]=data[p]}}var inst=new $.subformRepeatable(this,options);$(this).data("subformRepeatable",inst)})};$(window).on("load",function(){$("div.subform-repeatable").subformRepeatable()})})(jQuery);