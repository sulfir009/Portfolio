var isLoad = false;
var scriptEl = document.getElementById('tjsAppJS');
var offsetTop = 0;
var summaryOffset = 0;
var theme = '';
document.addEventListener("DOMContentLoaded", () => {
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	const urlSearchParams = new URLSearchParams(scriptEl.src);
	const para = Object.fromEntries(urlSearchParams);
	if (para['offsetTop']) {
		offsetTop = parseInt(para['offsetTop']);
	}
	if(window.innerWidth < 786){
		offsetTop = parseInt(para['offsetTopM']);
	}
	if (urlParams.get('summaryOffset')) {
		summaryOffset = urlParams.get('summaryOffset')
	}
	if (para['theme']) {
		theme = para['theme'];
	}
	window.addEventListener('resize', function windowResize(event) { });
	parentToTop = function () {
		if (inIframe()) {
			if (typeof (parentIFrame) !== 'undefined') {
				parentIFrame.scrollToOffset(0, 0);
			}
		}
	};
	parentToPosi = function () {
		if (inIframe()) {
			if (typeof (parentIFrame) !== 'undefined') {
				parentIFrame.scrollToOffset(0, 900);
			}
		}
	};
	scrlToElement = function (elem) {
		if (inIframe()) {
			if (typeof (parentIFrame) !== 'undefined') {
				parentIFrame.scrollToOffset(0, elem);
			}
		}
	}
	inIframe = function () {
		try {
			return window.self !== window.top;
		} catch (e) {
			return true;
		}
	}
	if (inIframe()) {
		var css = document.createElement("style");
		css.type = "text/css";
		css.innerHTML = ".tjs-embed-center,.cdk-global-overlay-wrapper{max-height: 800px;}.spinner-icon{top:300px !important;}";
		document.body.appendChild(css);
	}

	/* scroll function for sidebar */
	window.addEventListener('scroll', () => scrollCtrl(false, 0));
	/**Function to load lato font family */
	loadFonts();
	/**Function to apply global style */
	applyGlobalStyle();
});


window.addEventListener('message', (e) => {
	if (e.data.bodyscroll) {
		scrollCtrl(true, e.data.posi);
		if (document.querySelector('.toast-top-center')) {
			document.querySelector('.toast-top-center').style.top = e.data.posi + 'px';
		}
		let popupTopPosi = e.data.posi - offsetTop;
		if (document.querySelector('.cdk-global-overlay-wrapper')) {
			document.querySelector('.cdk-global-overlay-wrapper').style.top = popupTopPosi + 'px';
		}
		// if (document.querySelector('.tjs-embed-center')) {
		// 	document.querySelector('.tjs-embed-center').style.top = popupTopPosi + 'px';
		// }
		setPopupStyle(popupTopPosi)
		fixSummary(e.data.top, e.data.scrollTop, e.data.height);
	}
	if (e.data.referrerUrl) {
		var x = e.data.referrerUrl;
		var arr = x.split("/");
		var url = window.location.href;
		var arr2 = url.split("/");
		if (arr[2] != arr2[2]) {
			var lclStrg = '';
			try{
				lclStrg = localStorage.getItem("referrer_url");
			}catch(err){}
			if (!lclStrg) {
				try{
					localStorage.setItem("referrer_url", x);
				}catch(err){}
			}
		}
	}
	/** Set the cookie for campaign id **/
	if (e.data.campaign_id && e.data.campaign_id != '') {
		createCookie('campaign_id', e.data.campaign_id, 0)
	}
	/** Set the cookie for contact id **/
	if (e.data.contact_id && e.data.contact_id != '') {
		createCookie('contact_id', e.data.contact_id, 0)
	}
	/** Set the cookie for sequence_id **/
	if (e.data.sequence_id && e.data.sequence_id != '') {
		createCookie('sequence_id', e.data.sequence_id, 0)
	}
	/** Set the cookie for track_from **/
	if (e.data.track_from && e.data.track_from != '') {
		createCookie('track_from', e.data.track_from, 0)
	}
	/** Set the cookie for contact id **/
	/** Set the cookie for contact id **/
	if (e.data && ((e.data.industry_id && e.data.industry_id != '') || (e.data.form_id && e.data.form_id != '') || (e.data.location_id && e.data.location_id != '') || (e.data.first_name && e.data.first_name != '') || (e.data.last_name && e.data.last_name != '') || (e.data.email_id && e.data.email_id != '') || (e.data.phone_number && e.data.phone_number != '') || (e.data.service && e.data.service != '') || (e.data.frequency && e.data.frequency != '') || (e.data.zipcode && e.data.zipcode != '') || (e.data.service_hourly_value && e.data.service_hourly_value != '') || (e.data.coupon && e.data.coupon != '') || (e.data.date && e.data.date != '') || checkParamAvail(e.data))) {
		try{
			localStorage.setItem("embeded_params", JSON.stringify(e.data));
		}catch(err){}
		isLoad = true;
	} else if (!isLoad) {
		try{
			localStorage.removeItem("embeded_params");
		}catch(err){}
	}
}, { passive: true })

function checkParamAvail(res) {
	if (res) {
		for (var key in res) {
			/** To build the pricing param for form 1 **/
			if (key && key.includes("pricing_parameter[", 0) || key.includes("area_parameter[", 0) || key.includes("extras[", 0) || key.includes("excludes[", 0)) {
				return true;
			}
		}
	}
	return false;
}
function createCookie(name, value, days) {
	let expires;
	if (days) {
		let date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		expires = "; expires=" + date.toUTCString();
	} else {
		expires = "";
	}
	document.cookie = name + "=" + value + expires + "; path=/; SameSite=none;Secure";
}
function scrollCtrl(isParent = false, topPosi) {
	let bkFormElRef = document.querySelector('.booking-add-form');
	if (bkFormElRef && bkFormElRef.querySelector('#booking-summary-main')) {
		let summaryRefEl = bkFormElRef.querySelector('#booking-summary-box-ref');
		let bookingSummaryDefPos = getOffset(summaryRefEl).top;
		let prefixTopPosi = 0;
		if (summaryRefEl.getAttribute('data-margintop')) {
			prefixTopPosi = +(summaryRefEl.getAttribute('data-margintop'));
		}
		let marginTop = window.scrollY;
		if (isParent) {
			marginTop = topPosi;
		}
		let summaryRect = bkFormElRef.querySelector('#booking-summary-main').getBoundingClientRect();
		let formElRect = document.getElementById('booking-form-main').getBoundingClientRect();
		let maxHeight = ((getOffset(document.getElementById('booking-form-main')).top + formElRect.height) - summaryRect.height - 200) - prefixTopPosi;
		if (marginTop > bookingSummaryDefPos) {
			if (marginTop < maxHeight) {
				let newMarginTop = (marginTop - bookingSummaryDefPos) + 50 + prefixTopPosi;
				bkFormElRef.querySelector('#booking-summary-main').style.marginTop = newMarginTop + "px";
			}
		} else {
			bkFormElRef.querySelector('#booking-summary-main').style.marginTop = "0px";
		}
	}
}
function setPopupStyle(topPosi) {
	let styleTag = document.getElementById('popupStyle');
	if (styleTag) {
		styleTag.remove();
	}
	let css = document.createElement("style");
	css.id = "popupStyle";
	css.type = "text/css";
	css.innerHTML = ".tjs-embed-center,.cdk-global-overlay-wrapper{top: " + topPosi + "px;}";
	document.body.appendChild(css);
}
function fixSummary(top, scrollTop, height) {
	let posi = window.innerHeight - height - scrollTop + top + parseInt(summaryOffset);
	let bookingSummary = document.getElementById('booking-summary-box')
	if (bookingSummary) {
		bookingSummary.style.bottom = posi + 'px';
	}
}
function getOffset(el) {
	const rect = el.getBoundingClientRect();
	return {
		left: rect.left + window.scrollX,
		top: rect.top + window.scrollY
	};
}
/**
 * Function to lato font family
 */
function loadFonts() {
	let head = document.head || document.getElementsByTagName('head')[0];
	let gFontLink = document.createElement('link');
	gFontLink.href = 'https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap';
	gFontLink.rel = 'stylesheet';
	head.prepend(gFontLink);
}

/**
 * Function to apply global style
 */
function applyGlobalStyle() {
	/* code to append css and fonts */
	if (window.location.host != 'localhost:3200') {
		let baseUrl = window.location.protocol + "//" + window.location.host;
		// let baseUrl = 'https://hiringdev.bookingkoala.co.in';
		fetch(baseUrl + '/bktheme/v3/site/design-settings?theme_slug=' + theme).then(response => response.json())
			.then(data => {
				if (data && data.response && data.response.data && data.response.data.design_settings) {
					let style = "";
					let designSettings = data.response.data.design_settings;
					// code to apply font size and font family
					if (designSettings && designSettings.font_settings && designSettings.font_settings.enable_custom_font) {
						var fontStngs = designSettings.font_settings;
						WebFontConfig = {
							google: {
								families: [fontStngs.base_font_type + ':300,400,700,900&display=swap']
							}
						};
						(function (d) {
							let wf = d.createElement('script'), s = d.scripts[0];
							wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
							wf.async = true;
							s.parentNode.insertBefore(wf, s);
						})(document);
						if (fontStngs.base_font_type) {
							style += 'html,#bkIframe{font-family:' + fontStngs.base_font_type + ';}';
						}
						if (fontStngs.size) {
							style += '@media (min-width: 992px) {html,#bkIframe {font-size:'+ fontStngs.size +'px;}}';
						}
						if (fontStngs.mob_size) {
							style += '@media (max-width: 991px) {html,#bkIframe {font-size:'+ fontStngs.mob_size +'px;}}';
						}
					}
					// code to apply font colors
					if (designSettings.color_settings && designSettings.color_settings.enable_custom_colors) {
						let colorStngs = designSettings.color_settings;
						if (colorStngs.text_color) {
							style += '#bkIframe{color:' + colorStngs.text_color + ';}';
						}
						if (colorStngs.link_color) {
							style += 'a{color:' + colorStngs.link_color + ';}';
						}
						if (colorStngs.active_link_color) {
							style += 'a:active,a:hover{color:' + colorStngs.active_link_color + ';}';
						}
						if (colorStngs.heading_color) {
							style += 'h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6{ color:' + colorStngs.heading_color + ';}';
						}
						// Radio/checkbox
						if (colorStngs.radio_color) {
							style += '.form-check-input:checked{border-color:' + colorStngs.radio_color + ';background-color:' + colorStngs.radio_color + ';}'
						}
						// Calendar
						let cal_active_bg_color = (colorStngs.cal_active_bg_color) ? colorStngs.cal_active_bg_color : '';
						let cal_active_color = (colorStngs.cal_active_color) ? colorStngs.cal_active_color : '';
						if (cal_active_bg_color || cal_active_color) {
							style += '.tjs-bcalendar__active:not(.tjs-bcalendar__past-date){background:' + cal_active_bg_color + ';color:' + cal_active_color + ';}';
							style += '.tjs-bcalendar__day:hover:not(.tjs-bcalendar__past-date){background:' + cal_active_bg_color + ';color:' + cal_active_color + ';}';
							style += '.tjs-bcalendar__today:not(.tjs-bcalendar__active):hover{background:' + cal_active_bg_color + ';color:' + cal_active_color + ';}';
						}
					}
					// custom css
					if (designSettings.custom_css && designSettings.custom_css.css) {
						style += designSettings.custom_css.css;
					}
					let existingStyleSheet = document.getElementById('global-style');
					if (existingStyleSheet) {
						existingStyleSheet.parentNode.removeChild(existingStyleSheet);
					}
					// let head = document.head || document.getElementsByTagName('head')[0], styleTag = document.createElement('style');
					// head.appendChild(styleTag);
					let styleTag = document.createElement('style');
					document.body.appendChild(styleTag);
					styleTag.type = 'text/css';
					styleTag.id = 'global-style';
					styleTag.appendChild(document.createTextNode(style));
				} else {
					// console.log('colors and fonts not loaded')
				}
			});
	}
}

/**Polyfill js for safari smooth scroll issue */
!function(){"use strict";function o(){var o=window,t=document;if(!("scrollBehavior"in t.documentElement.style&&!0!==o.__forceSmoothScrollPolyfill__)){var l,e=o.HTMLElement||o.Element,r=468,i={scroll:o.scroll||o.scrollTo,scrollBy:o.scrollBy,elementScroll:e.prototype.scroll||n,scrollIntoView:e.prototype.scrollIntoView},s=o.performance&&o.performance.now?o.performance.now.bind(o.performance):Date.now,c=(l=o.navigator.userAgent,new RegExp(["MSIE ","Trident/","Edge/"].join("|")).test(l)?1:0);o.scroll=o.scrollTo=function(){void 0!==arguments[0]&&(!0!==f(arguments[0])?h.call(o,t.body,void 0!==arguments[0].left?~~arguments[0].left:o.scrollX||o.pageXOffset,void 0!==arguments[0].top?~~arguments[0].top:o.scrollY||o.pageYOffset):i.scroll.call(o,void 0!==arguments[0].left?arguments[0].left:"object"!=typeof arguments[0]?arguments[0]:o.scrollX||o.pageXOffset,void 0!==arguments[0].top?arguments[0].top:void 0!==arguments[1]?arguments[1]:o.scrollY||o.pageYOffset))},o.scrollBy=function(){void 0!==arguments[0]&&(f(arguments[0])?i.scrollBy.call(o,void 0!==arguments[0].left?arguments[0].left:"object"!=typeof arguments[0]?arguments[0]:0,void 0!==arguments[0].top?arguments[0].top:void 0!==arguments[1]?arguments[1]:0):h.call(o,t.body,~~arguments[0].left+(o.scrollX||o.pageXOffset),~~arguments[0].top+(o.scrollY||o.pageYOffset)))},e.prototype.scroll=e.prototype.scrollTo=function(){if(void 0!==arguments[0])if(!0!==f(arguments[0])){var o=arguments[0].left,t=arguments[0].top;h.call(this,this,void 0===o?this.scrollLeft:~~o,void 0===t?this.scrollTop:~~t)}else{if("number"==typeof arguments[0]&&void 0===arguments[1])throw new SyntaxError("Value could not be converted");i.elementScroll.call(this,void 0!==arguments[0].left?~~arguments[0].left:"object"!=typeof arguments[0]?~~arguments[0]:this.scrollLeft,void 0!==arguments[0].top?~~arguments[0].top:void 0!==arguments[1]?~~arguments[1]:this.scrollTop)}},e.prototype.scrollBy=function(){void 0!==arguments[0]&&(!0!==f(arguments[0])?this.scroll({left:~~arguments[0].left+this.scrollLeft,top:~~arguments[0].top+this.scrollTop,behavior:arguments[0].behavior}):i.elementScroll.call(this,void 0!==arguments[0].left?~~arguments[0].left+this.scrollLeft:~~arguments[0]+this.scrollLeft,void 0!==arguments[0].top?~~arguments[0].top+this.scrollTop:~~arguments[1]+this.scrollTop))},e.prototype.scrollIntoView=function(){if(!0!==f(arguments[0])){var l=function(o){for(;o!==t.body&&!1===(e=p(l=o,"Y")&&a(l,"Y"),r=p(l,"X")&&a(l,"X"),e||r);)o=o.parentNode||o.host;var l,e,r;return o}(this),e=l.getBoundingClientRect(),r=this.getBoundingClientRect();l!==t.body?(h.call(this,l,l.scrollLeft+r.left-e.left,l.scrollTop+r.top-e.top),"fixed"!==o.getComputedStyle(l).position&&o.scrollBy({left:e.left,top:e.top,behavior:"smooth"})):o.scrollBy({left:r.left,top:r.top,behavior:"smooth"})}else i.scrollIntoView.call(this,void 0===arguments[0]||arguments[0])}}function n(o,t){this.scrollLeft=o,this.scrollTop=t}function f(o){if(null===o||"object"!=typeof o||void 0===o.behavior||"auto"===o.behavior||"instant"===o.behavior)return!0;if("object"==typeof o&&"smooth"===o.behavior)return!1;throw new TypeError("behavior member of ScrollOptions "+o.behavior+" is not a valid value for enumeration ScrollBehavior.")}function p(o,t){return"Y"===t?o.clientHeight+c<o.scrollHeight:"X"===t?o.clientWidth+c<o.scrollWidth:void 0}function a(t,l){var e=o.getComputedStyle(t,null)["overflow"+l];return"auto"===e||"scroll"===e}function d(t){var l,e,i,c,n=(s()-t.startTime)/r;c=n=n>1?1:n,l=.5*(1-Math.cos(Math.PI*c)),e=t.startX+(t.x-t.startX)*l,i=t.startY+(t.y-t.startY)*l,t.method.call(t.scrollable,e,i),e===t.x&&i===t.y||o.requestAnimationFrame(d.bind(o,t))}function h(l,e,r){var c,f,p,a,h=s();l===t.body?(c=o,f=o.scrollX||o.pageXOffset,p=o.scrollY||o.pageYOffset,a=i.scroll):(c=l,f=l.scrollLeft,p=l.scrollTop,a=n),d({scrollable:c,method:a,startTime:h,startX:f,startY:p,x:e,y:r})}}"object"==typeof exports&&"undefined"!=typeof module?module.exports={polyfill:o}:o()}();