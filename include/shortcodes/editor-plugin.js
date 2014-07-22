/**
 * This file contains all the main JavaScript functionality needed for the editor formatting buttons.
 * 
 */

/**
 * Define all the formatting buttons with the HTML code they set.
 */
var shortcodeButton=[
		{
			id:'dropcaps',
			image:'drop.png',
			title:'Drop Caps',
			allowSelection:true,
			fields:[{id:'letter', name:'Letter'}],
			generateHtml:function(letter){
				return '[dropcaps]'+letter+'[/dropcaps]';
			}
		},
		{
			id:'hr',
			image:'hl_d.png',
			title:'Horizontal Rule',
			allowSelection:true,
			generateHtml:function(){
				var html='';
				html='[hr]';
				return html;
			}
		},
		{
			id:'liststyle1',
			image:'ico-style1.png',
			title:'List Style 1',
			allowSelection:false,
			generateHtml:function(obj){
				return '[list style="style1"]<br />[li]yout text here[/li]<br />[li]yout text here[/li]<br />[li]yout text here[/li]<br />[/list]';
			}
		},
		{
			id:'liststyle2',
			image:'ico-style2.png',
			title:'List Style 2',
			allowSelection:false,
			generateHtml:function(obj){
				return '[list style="style2"]<br />[li]yout text here[/li]<br />[li]yout text here[/li]<br />[li]yout text here[/li]<br />[/list]';
			}
		},
		{
			id:'liststyle3',
			image:'ico-style3.png',
			title:'List Style 3',
			allowSelection:false,
			generateHtml:function(obj){
				return '[list style="style3"]<br />[li]yout text here[/li]<br />[li]yout text here[/li]<br />[li]yout text here[/li]<br />[/list]';
			}
		},
		{
			id:'liststyle4',
			image:'ico-style4.png',
			title:'List Style 4',
			allowSelection:false,
			generateHtml:function(obj){
				return '[list style="style4"]<br />[li]yout text here[/li]<br />[li]yout text here[/li]<br />[li]yout text here[/li]<br />[/list]';
			}
		},
		{
			id:'liststyle5',
			image:'ico-style5.png',
			title:'List Style 5',
			allowSelection:false,
			generateHtml:function(obj){
				return '[list style="style5"]<br />[li]yout text here[/li]<br />[li]yout text here[/li]<br />[li]yout text here[/li]<br />[/list]';
			}
		},
		{
			id:'liststyle6',
			image:'ico-style6.png',
			title:'List Style 6',
			allowSelection:false,
			generateHtml:function(obj){
				return '[list style="style6"]<br />[li]yout text here[/li]<br />[li]yout text here[/li]<br />[li]yout text here[/li]<br />[/list]';
			}
		},
		{
			id:'frame',
			image:'fr.png',
			title:'Image frame',
			allowSelection:false,
			fields:[{id:'src', name:'Image URL'},{id:'align', name:'Align', values:['none', 'left', 'right']}],
			generateHtml:function(obj){
				var imgclass=obj.align==='none'?'':'align="'+obj.align;
				return '<img class="img-frame" '+imgclass+'" src="'+obj.src+'" />';
			}
		},
		{
			id:'lightbox',
			image:'lb.png',
			title:'Lightbox image',
			allowSelection:false,
			fields:[{id:'src', name:'Thumbnail URL'}, {id:'href', name:'Preview Image URL'}, {id:'description', name:'Description'}, {id:'align', name:'Align', values:['none', 'left', 'right']}],
			generateHtml:function(obj){
			var imgclass=obj.align==='none'?'':'align="'+obj.align;
				return '<div><a rel="prettyPhoto[pp_gal]" href="'+obj.href+'" title="'+obj.description+'"><img class="img-frame" '+imgclass+'" src="'+obj.src+'" /></a></div>';
			}
		},
		
		{
			id:'infoboxes',
			image:'info.png',
			title:'Info Box',
			allowSelection:false,
			fields:[{id:'text', name:'Text', textarea:true},{id:'type', name:'Type', values:['alert', 'note', 'notice','success','warning','download']}],
			generateHtml:function(obj){
				return '[info_box type="'+obj.type+'_box">'+obj.text+'[/info_box]';
			}
		},
		{
			id:'twocolumns',
			image:'col_2.png',
			title:'Two Columns',
			allowSelection:false,
			fields:[{id:'columnone', name:'Column One Content', textarea:true}, {id:'columntwo', name:'Column Two Content', textarea:true}],
			generateHtml:function(obj){
				return '[col_wrapper]<br />[col2]'+obj.columnone+'[/col2]<br />[col2_last]'+obj.columntwo+'[/col2_last]<br />[/col_wrapper]';
			}
		},
		{
			id:'threecolumns',
			image:'col_3.png',
			title:'Three Columns',
			allowSelection:false,
			fields:[{id:'columnone', name:'Column One Content', textarea:true}, {id:'columntwo', name:'Column Two Content', textarea:true}, {id:'columnthree', name:'Column Three Content', textarea:true}],
			generateHtml:function(obj){
				return '[col_wrapper]<br />[col3]'+obj.columnone+'[/col3]<br />[col3]'+obj.columntwo+'[/col3]<br />[col3_last]'+obj.columnthree+'[/col3_last]<br />[/col_wrapper]';
			}
		},
		{
			id:'fourcolumns',
			image:'col_4.png',
			title:'Four Columns',
			allowSelection:false,
			fields:[{id:'columnone', name:'Column One Content', textarea:true}, {id:'columntwo', name:'Column Two Content', textarea:true}, {id:'columnthree', name:'Column Three Content', textarea:true}, {id:'columnfour', name:'Column Four Content', textarea:true}],
			generateHtml:function(obj){
				return '[col_wrapper]<br />[col4]'+obj.columnone+'[/col4]<br />[col4]'+obj.columntwo+'[/col4]<br />[col4]'+obj.columnthree+'[/col4]<br />[col4_last]'+obj.columnfour+'[/col4_last]<br />[/col_wrapper]';
			}
		},
		{
			id:'twothird',
			image:'col2_3.png',
			title:'Two-Third/One-Third Columns',
			allowSelection:false,
			fields:[{id:'columnone', name:'Column One Content', textarea:true}, {id:'columntwo', name:'Column Two Content', textarea:true}],
			generateHtml:function(obj){
				return '[col_wrapper]<br />[col2_3]'+obj.columnone+'[/col2_3]<br />[col3_last]'+obj.columntwo+'[/col3_last]<br />[/col_wrapper]';
			}
		},	
		{
			id:'threefourth',
			image:'col3_4.png',
			title:'Three-Fourth/One-Fourth Columns',
			allowSelection:false,
			fields:[{id:'columnone', name:'Column One Content', textarea:true}, {id:'columntwo', name:'Column Two Content', textarea:true}],
			generateHtml:function(obj){
				return '[col_wrapper]<br />[col3_4]'+obj.columnone+'[/col3_4]<br />[col4_last]'+obj.columntwo+'[/col4_last]<br />[/col_wrapper]';
			}
		},		
		{
			id:'toggle',
			image:'toggle.png',
			title:'Toggle Box',
			allowSelection: false,
			fields:[{id:'toggletitle' , name:'Title'},{id:'toggleitemtitle', name:'Toggle Item Title'}, {id:'content', name:'Content', textarea: true},{id:'toggleitemtitle2', name:'Toggle Item Title'}, {id:'content2', name:'Content', textarea: true},{id:'toggleitemtitle3', name:'Toggle Item Title'}, {id:'content3', name:'Content', textarea: true}],
			generateHtml:function(obj){
				var html='';

				html='[toggle title="'+obj.toggletitle+'"][toggleitem title="'+obj.toggleitemtitle+'"]'+obj.content+'[/toggleitem][toggleitem title="'+obj.toggleitemtitle2+'"]'+obj.content2+'[/toggleitem][toggleitem title="'+obj.toggleitemtitle3+'"]'+obj.content3+'[/toggleitem][/toggle]';
				
				return html;
			}
		},
			{
			id:'tabs',
			image:'tabs.png',
			title:'jQuery Tab',
			allowSelection:false,
			fields:[{id:'tab1', name:'First Tab Title'}, {id:'content1', name:'First Content', textarea: true}, {id:'tab2', name:'Second Tab Title'}, {id:'content2', name:'Second Content', textarea: true},{id:'tab3', name: 'Third Tab Title'},{id:'content3', name:'Third Content' , textarea: true}],
			generateHtml:function(obj){
			
			var html='';
				html='[tabs titles="'+obj.tab1+','+obj.tab2+','+obj.tab3+'"] [pane] '+obj.content1+' [/pane] [pane] '+obj.content2+' [/pane] [pane] '+obj.content3+' [/pane][/tabs]';
						
				return html;
			}
		},
		{
			id:'accordion',
			image:'accordion.png',
			title:'jQuery Accordion',
			allowSelection:false,
			fields:[{id:'accordiontitle' , name:'Title'},{id:'accordionitemtitle', name:'Item Title'}, {id:'content', name:'Content', textarea: true},{id:'accordionitemtitle2', name:'Item Title'}, {id:'content2', name:'Content', textarea: true},{id:'accordionitemtitle3', name:'Item Title'}, {id:'content3', name:'Content', textarea: true}],
			generateHtml:function(obj){
			
			var html='';
				html='[accordion title="'+obj.accordiontitle+'"]<br />[accordionitem title="'+obj.accordionitemtitle+'"]'+obj.content+'[/accordionitem]<br />[accordionitem title="'+obj.accordionitemtitle2+'"]'+obj.content2+'[/accordionitem]<br />[accordionitem title="'+obj.accordionitemtitle3+'"]'+obj.content3+'[/accordionitem]<br />[/accordion]';
						
				return html;
			
			}
		},
		{
			id:'servicebox',
			image:'servicebox.png',
			title:'Service Box',
			allowSelection:false,
			generateHtml:function(obj){
			
			
				html='[servicebox_wrapper]<br />[servicebox size="one-half" last="false" title="YOUR_TITLE" icon="G"  icon_color="#" name="Purchase" link="#" btnsize="default" color="default" rounded="false" ]CONTENT_HERE[/servicebox]<br />[servicebox size="one-half" last="true" title="YOUR_TITLE" icon="G"  icon_color="#" name="Purchase" link="#" btnsize="default" color="default" rounded="false" ]CONTENT_HERE[/servicebox]<br />[/servicebox_wrapper]';
						
				return html;
			
			}
		},
		{
			id:'testimonial',
			image:'testimonial.png',
			title:'Testimonial Shortcode',
			allowSelection: false,
			generateHtml:function(obj){
				return '[testimonial title="Testimonial" size="SIZE" ]<br />[testi_pane name="JOHN DOE" position="WED DESIGNER"] CONTENT GOES HERE.... [/testi_pane]<br />[testi_pane name="JANE DOE" position="WED DESIGNER"] CONTENT GOES HERE.... [/testi_pane]<br />[/testimonial]';
			
			}
		},
		{
			id:'team',
			image:'team.png',
			title:'Team',
			allowSelection:false,
			generateHtml:function(obj){
			
			var html='';
				html='[team_wrapper]<br />[team size="one-half" last="false" name="YOUR_NAME" title="YOUR_TITLE" icon="IMG_URL" facebook="#" twitter="#" gmail="#" ]CONTENT_HERE[/team]<br />[team size="one-half" last="true" name="YOUR_NAME" title="YOUR_TITLE" icon="IMG_URL" facebook="#" twitter="#" gmail="#" ]CONTENT_HERE[/team]<br />[/team_wrapper]';
						
				return html;
			
			}
		},		
		{
			id:'button',
			image:'but.png',
			title:'Button',
			allowSelection:false,
			fields:[{id:'linked' , name:'Link'},{id:'size', name:'Size', values:['small','medium','large']},{id:'color', name:'Color', values:['blue','red','black','orange','green']},{id:'rounded', name:'Rounded', values:['true','false']},{id:'buttonname' , name:'Button Name'}],
			generateHtml:function(obj){
			
			var html='';
				html='[button link="'+obj.linked+'" size="'+obj.size+'" color="'+obj.color+'" rounded="'+obj.rounded+'" ]'+obj.buttonname+'[/button]';
						
				return html;
			
			}
		},
		{
			id:'slider',
			image:'slide.png',
			title:'Image Slider',
			allowSelection: false,
			fields:[{id:'name' , name:'Name'},{id:'height', name:'Height'}, {id:'width', name:'Width'},{id:'slideshow', name:'Slideshow'},{id:'caption', name:'Caption',values:['true','false']}, {id:'animation', name:'Animation', values:['fade','slide']}, {id:'directionnav', name:'Direction Nav', values:['true','false']},{id:'controlnav', name:'Control Nav',values:['true','false']}, {id:'order', name:'Order',values:['ASC','DESC']}],
			generateHtml:function(obj){
				var html='';

				html='[slider name="'+obj.name+'" height="'+obj.height+'" width="'+obj.width+'" slideshow="'+obj.slideshow+'" caption="'+obj.caption+'" animation="'+obj.animation+'"  directionnav="'+obj.directionnav+'" controlnav="'+obj.controlnav+'" order="'+obj.order+'"]';
				
				return html;
			}
		},
		{
			id:'call_to_action',
			image:'call_to_action.png',
			title:'Call To Action',
			allowSelection: false,
			generateHtml:function(obj){
				return '[call_to_action link="#" button_label="View More" rounded="false" btnsize="medium" color=""]<h2>MAECENAS FAUCIBUS MOLLIS INTERDUM. CURABITUR BLANDIT TEMPUS PORTTITOR</h2><p>Quisque ligulas ipsum, euismod atras vulputate iltricies etri elit. Class aptent taciti sociosqu </p>[/call_to_action]';
			
			}
		},
		{
			id:'portfolio',
			image:'portfolio.png',
			title:'Portfolio Shortcode',
			allowSelection: false,
			generateHtml:function(obj){
				return '[portfolio type="filter" items="6"][/portfolio]';
			
			}
		},
		{
			id:'recent_blog',
			image:'recent_blog.png',
			title:'Recent Blog Shortcode',
			allowSelection: false,
			generateHtml:function(obj){
				return '[recent_blog columns="3" items="6" category=""][/recent_blog]';
			
			}
		},	
		{
			id:'client',
			image:'client.png',
			title:'Client Shortcode',
			allowSelection: false,
			generateHtml:function(obj){
				return '[client]<br />[client_item name="NAME" link="LINK" image="IMAGE_URL"][/client_item]<br />[client_item name="NAME" link="LINK" image="IMAGE_URL"][/client_item]<br />[client_item name="NAME" link="LINK" image="IMAGE_URL"][/client_item]<br />[client_item name="NAME" link="LINK" image="IMAGE_URL"][/client_item]<br />[/client]';
			
			}
		},				

];

/**
 * Contains the main formatting buttons functionality.
 */
ButtonManager={
	dialog:null,
	idprefix:'shortcode-',
	ie:false,
	opera:false,
		
	/**
	 * Init the formatting button functionality.
	 */
	init:function(){
			
		var length=shortcodeButton.length;
		for(var i=0; i<length; i++){
		
			var btn = shortcodeButton[i];
			ButtonManager.loadButton(btn);
		}
		
		if ( jQuery.browser.msie ) {
			ButtonManager.ie=true;
		}
		
		if (jQuery.browser.opera){
			ButtonManager.opera=true;
		}
		
	},
	
	/**
	 * Loads a button and sets the functionality that is executed when the button has been clicked.
	 */
	loadButton:function(btn){
		tinymce.create('tinymce.plugins.'+btn.id, {
	        init : function(ed, url) {
			        ed.addButton(btn.id, {
	                title : btn.title,
	                image : url+'/shortcode_icons/'+btn.image,
	                onclick : function() {
			        	
			           var selection = ed.selection.getContent();
					  
	                  if(btn.allowSelection && selection){
	                	   //modification via selection is allowed for this button and some text has been selected
	                	   selection = btn.generateHtml(selection);
	                	   ed.selection.setContent(selection);
	                   }else if(btn.fields){
	                	   //there are inputs to fill in, show a dialog to fill the required data

	                	   ButtonManager.showDialog(btn, ed);
	                   }else if(btn.list){
	                
	                	    //this is a list
	                	    var list, dom = ed.dom, sel = ed.selection;
	                	    
							
							// Check for existing list element
		               		list = dom.getParent(sel.getNode(), 'ul');
		               		
		               		// Switch/add list type if needed
		               		ed.execCommand('InsertUnorderedList');
		               		
		               		// Append styles to new list element
		               		list = dom.getParent(sel.getNode(), 'ul');
		               		
		               		if (list) {
		               			dom.addClass(list, btn.list);
		               			dom.addClass(list, 'imglist');
		               		}
	                   }else{
	                	   //no data is required for this button, insert the generated HTML
	                	   ed.execCommand('mceInsertContent', true, btn.generateHtml());
	                   }
	                }
	            });
	        }
	    });
		
	    tinymce.PluginManager.add(btn.id, tinymce.plugins[btn.id]);
	},
	
	/**
	 * Displays a dialog that contains fields for inserting the data needed for the button.
	 */
	showDialog:function(btn, ed){

		
		if(ButtonManager.ie){
			ed.dom.remove('caret');
		    var caret = '<div id="caret">&nbsp;</div>';
		    ed.execCommand('mceInsertContent', false, caret);	
			var selection = ed.selection;
		}
	    
		var html='<div>';
		for(var i=0, length=btn.fields.length; i<length; i++){
			var field=btn.fields[i], inputHtml='';
			if(btn.fields[i].values){
				//this is a select list
				inputHtml='<select id="'+ButtonManager.idprefix+btn.fields[i].id+'">';
				jQuery.each(btn.fields[i].values, function(index, value){
					inputHtml+='<option value="'+value+'">'+value+'</option>';
				});
				inputHtml+='</select>';
			}else{
				if(btn.fields[i].textarea && !ButtonManager.opera){
					//this field should be a text area
					inputHtml='<textarea id="'+ButtonManager.idprefix+btn.fields[i].id+'" ></textarea>';
				}else{
					//this field should be a normal input
					inputHtml='<input type="text" id="'+ButtonManager.idprefix+btn.fields[i].id+'" />';
				}
			}
			html+='<div class="shortcode-field"><label>'+btn.fields[i].name+'</label>'+inputHtml+'</div>';
		}
		html+='<a href="" id="insertbtn" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button"><span class="ui-button-text">Insert</span></a></div>';
	
		var dialog = jQuery(html).dialog({
							 title:btn.title, 
							 modal:true,
							 close: function(event, ui){
								jQuery(this).html('').remove();
							}
							 });
		
		ButtonManager.dialog=dialog;
		
		//set a click handler to the insert button
		dialog.find('#insertbtn').click(function(event){
			event.preventDefault();
			ButtonManager.executeCommand(ed,btn,selection);
		});
		
			
	},
	
	/**
	 * Executes a command when the insert button has been clicked.
	 */
	executeCommand:function(ed, btn, selection){

    		var values={}, html='';
    		
    		if(!btn.allowSelection){
    			//the button doesn't allow selection, generate the values as an object literal
	    		for(var i=0, length=btn.fields.length; i<length; i++){
	        		var id=btn.fields[i].id,
	        			value=jQuery('#'+ButtonManager.idprefix+id).val();
	        		
	    			values[id]=value;
	    		}
	    		html = btn.generateHtml(values);
    		}else{
    			//the button allows selection - only one value is needed for the formatting, so
    			//return this value only (not an object literal)
    			value = jQuery('#'+ButtonManager.idprefix+btn.fields[0].id).attr("value")
    			html = btn.generateHtml(value);
    		}
    		
    	ButtonManager.dialog.remove();

    	if(ButtonManager.ie){
	    	selection.select(ed.dom.select('div#caret')[0], false);
	    	ed.dom.remove('caret');
    	}

  		ed.execCommand('mceInsertContent', false, html);
    	
	}
		
		
};


/**
 * Init the formatting functionality.
 */
(function() {
	
	ButtonManager.init();
	/*Tooltip();*/
	
			
		
    
})();