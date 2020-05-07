/* Nav Accordion Plugin v1.1.2
************************************/
(function($){
	$.fn.navAccordion = function(options, callback){
		this.each(function(){
			
			//Options
			var settings = $.extend({
				expandButtonText : "+", //Text inside of expand button
				collapseButtonText: "-",  //Text inside of collapse button
				selectedExpand: "true",   //Expand the selected channel
				selectedClass: "selected",  //Class that will be used to detect the currently selected channel - this will check the "parentElement" for this class (the parent <li> by default)
				multipleLevels: "true",  //Apply accordion to all levels - setting this to false will apply the accordion only to the first level
				buttonWidth: "20%",  //Width of accordion expand/collapse button as a percentage or pixels
				buttonPosition: "right",  //Position of button - 'right' is default - you can also choose 'left'
				slideSpeed: "fast",   //Speed of slide animation - "fast", "slow", or number in milliseconds such as 500
				parentElement: "li",  //Parent element type, class or ID - you don't need to change this if you're using a ul > li > ul pattern
				childElement: "ul",   //Child element type, class or ID - you don't need to change this if you're using a ul > li > ul pattern
				headersOnly: false,  //False is default - setting to true will make any link with sub-nav behave as if it were set to header only, making the link inaccessible - this option is useful if you are using the plugin for a non-navigation area
				headersOnlyCheck: false, // False is default - set to true to apply the accordion only to links that are set as "header only" (have no href)
				delayLink: false,  //Delay following the href of links until after the accordion the has expanded
				delayAmount: null //Time in milliseconds to delay before following href - will use "slideSpeed" by default if nothing else is set
			}, options);
			
			var container = this,
			//Multiple levels variable
				multi = settings.multipleLevels ? '': ' > ' + settings.childElement + ' > ';
				
			//Add class to container
			$(container)
				.addClass('accordion-nav');
			
			//Apply has-subnav class to lis with uls - also add accordion buttons with styles
			$(multi + settings.parentElement, container).each(function(){
				if ( ($(this).contents(settings.childElement).length > 0 
					&& settings.headersOnlyCheck == false) || (!($('> a', this).attr('href')) 
					&& settings.headersOnlyCheck == true) )  
				{
					//Apply Class and styles to parent item
					$(this).addClass('has-subnav')
						.css('position', 'relative')
							.find('>a')
								.css('margin-' + settings.buttonPosition, settings.buttonWidth);
					
					//Add expand button elements
					$(' > ' + settings.childElement, this)
						.before('<span class="accordion-btn-wrap"><span class="accordion-btn accordion-collapsed">'
						+ settings.expandButtonText + '</span><span class="accordion-btn accordion-expanded">'
						+ settings.collapseButtonText + '</span></span>');
						
					//Apply Styles to expand button
					$('.accordion-btn-wrap', this)
						.css({
							'width': settings.buttonWidth, 
							'position': 'absolute', 
							'top': 0, 
							'text-align': 'center', 
							'cursor': 'pointer', 
							'display': 'inline-block'
						})
						.css(settings.buttonPosition, 0);
					$('.accordion-btn ', this)
						.css({
							'display': 'inline-block', 
							'width': '100%'
						});
					$('.accordion-expanded', this)
						.css('display', 'none');
				}
				
				//Apply styles to <a> tags that are set to header only
				if (!($('> a', this).attr('href')) || settings.headersOnly){
					$(this)
						.addClass('accordion-header-only')
							.find('.accordion-btn-wrap')
								.css({
									'width': '100%', 
									'text-align': settings.buttonPosition
								})
								.find('.accordion-btn ')
									.css({
										'width': settings.buttonWidth, 
										'text-align': 'center'
									});
				}
				
				//Delay Link Mode
				if (settings.delayLink && !settings.headersOnly) {
					var currentThis = this,
						speed = settings.delayAmount != null ? settings.delayAmount : settings.slideSpeed;
					if (speed == "fast") {
						speed = 200;
					} else if (speed == "slow") {
						speed = 600;
					}
					$('> a', currentThis).on('click',function(e){
						if (!$('> .accordion-btn-wrap', currentThis).hasClass("accordion-active")) {
							e.preventDefault();
							var href = $(this).attr('href');
							clickToggle($('> .accordion-btn-wrap', currentThis));
							//Go to link after delay
							setTimeout(function(){
								window.location = href;
							}, speed)
						}
					})
				}
				
			});
			
			var selectedNavAccordion = $(settings.parentElement + '.' + settings.selectedClass + ' > .accordion-btn-wrap', container);
			
			//Debounced Button height event listener
			var buttonheightResize = debounce(function(){
				//Run button height
				buttonheight();
				//Expand Selected Channel
				expandSelected();
			}, 250);
			$(window).on('resize', buttonheightResize);
			
			//Set button heights
			buttonheight();
			
			//Expand Selected Channel
			expandSelected();
			
			//On click function
			$(container).on('click', '.accordion-btn-wrap', function(e) {
				e.preventDefault();
				clickToggle(this);
			});
			
			//Callback
			if (typeof callback == "function") {
				callback();
			}
			
			
			/* Functions 
			*******************************/
				//Click Toggle function
				function clickToggle(element) {
					var nextChild = $(element).next(settings.childElement),
						currentExpandBtn = $('.accordion-expanded', element),
						currentCollapseBtn = $('.accordion-collapsed', element),
						parentObj = $(element).closest(settings.parentElement);
					if (nextChild.is(':visible')) {
						nextChild
							.slideUp(settings.slideSpeed);
						$(element)
							.removeClass('accordion-active');
						currentExpandBtn
							.css('display', 'none');
						currentCollapseBtn
							.css('display', 'inline-block');
						parentObj.add(parentObj.siblings('.active')).add(parentObj.find('.active')).removeClass('active');
					} else {
						$(element).closest(settings.childElement).find('.accordion-active')
							.removeClass('accordion-active')
							.next(settings.childElement)
								.slideUp(settings.slideSpeed).prev()
								.find('.accordion-expanded')
									.css('display', 'none')
									.parent().find('.accordion-collapsed')
										.css('display', 'inline-block');
						parentObj.add(parentObj.siblings('.active')).add(parentObj.find('.active')).removeClass('active');
						$(element)
							.addClass('accordion-active');
						nextChild
							.slideToggle(settings.slideSpeed);
						currentExpandBtn
							.css('display', 'inline-block');
						currentCollapseBtn
							.css('display', 'none');
						parentObj.addClass('active');
					}
				}
				
				//Expand Selected Channel Function
				function expandSelected(){
					if(settings.selectedExpand){
						if(!settings.headersOnlyCheck){
						selectedNavAccordion.find('.accordion-expanded')
							.css('display', 'inline-block');
						selectedNavAccordion.find('.accordion-collapsed')
							.css('display', 'none');
						selectedNavAccordion.addClass('accordion-active')
							.next(settings.childElement)
								.css('display', 'block');
						selectedNavAccordion.closest(settings.parentElement)
							.addClass('active');
						} else {
							$(settings.parentElement + '.' + settings.selectedClass + ' > ' + settings.childElement, container)
								.css('display', 'block');
								$(settings.parentElement + '.' + settings.selectedClass).addClass('active');
						}
					}
				}
			
				//Accordion Button Height Function
				function buttonheight(){
					$('.accordion-btn', container).each(function(){
						//Show uls so heights are calculated correctly
						$(settings.parentElement + '.has-subnav > ' + settings.childElement, container)
							.css('display', 'block');
						
						//Calculate and set heights
						var parentItem = $(this).closest(settings.parentElement),
							lineheight =  $('> a', parentItem).innerHeight();
						$(this)
							.css({'line-height': lineheight + 'px', 'height': lineheight});
						
						//Hide uls under lis and reset expand/collapse buttons
						$(settings.parentElement + ((settings.headersOnlyCheck) ? ' ' : '.has-subnav > ') + settings.childElement, container)
							.css('display', 'none');
						$('.accordion-expanded')
							.css('display', 'none');
						$('.accordion-collapsed')
							.css('display', 'inline-block');
					})
				}
							
				//Debounce function
				function debounce(func, wait, immediate) {
					var timeout;
					return function() {
						var context = this, args = arguments;
						var later = function() {
							timeout = null;
							if (!immediate) func.apply(context, args);
						};
						var callNow = immediate && !timeout;
						clearTimeout(timeout);
						timeout = setTimeout(later, wait);
						if (callNow) func.apply(context, args);
					};
				};
			
			
		});
	}
})(jQuery);