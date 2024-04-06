$(".burger").click(function(){
    $(".mob_menu").toggleClass( "mob_menu_open" );
    $(this).toggleClass( "burger_active" );
});
$('.main_slider').slick({
infinite: true,
  slidesToShow: 1,
  slidesToScroll: 1,
  pauseOnHover:false,
  autoplay: false, 
  autoplaySpeed: 3000,
  fade: true,
  arrows:true, 
  dots:true,
  draggable: true,
  prevArrow: '<div class="prev"></div>',
nextArrow: '<div class="next"></div>',
});
$(window).scroll(function () {
  if ($(this).scrollTop() > 0) {
    $("header").addClass("header_sticky");
  } else {
    $("header").removeClass("header_sticky");
  }
});
$('.product_items').slick({
   infinite: true,
  slidesToShow: 4,
  slidesToScroll: 1,
  pauseOnHover:false,
  autoplay: false, 
  autoplaySpeed: 3000,
  arrows:false, 
  dots:true,
  prevArrow: '<div class="prev"></div>',
nextArrow: '<div class="next"></div>',
responsive: [
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 1,
        autoplay: false,
        arrows:true,
      }
    },
    {
      breakpoint: 720,
      settings: {
        slidesToShow: 1,
        autoplay: false,
        arrows:true,
      }
    }
  ]
});
// $(".product_item").hover(
//     function() {
//         $(this).find("div.product_item_desc").slideToggle("fast");
//     },
//     function() {
//         $(this).find("div.product_item_desc").slideToggle("fast");
//     }
// );
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof exports?require("jquery"):jQuery)}(function(a){var b,c=navigator.userAgent,d=/iphone/i.test(c),e=/chrome/i.test(c),f=/android/i.test(c);a.mask={definitions:{9:"[0-9]",a:"[A-Za-z]","*":"[A-Za-z0-9]"},autoclear:!0,dataName:"rawMaskFn",placeholder:"_"},a.fn.extend({caret:function(a,b){var c;if(0!==this.length&&!this.is(":hidden"))return"number"==typeof a?(b="number"==typeof b?b:a,this.each(function(){this.setSelectionRange?this.setSelectionRange(a,b):this.createTextRange&&(c=this.createTextRange(),c.collapse(!0),c.moveEnd("character",b),c.moveStart("character",a),c.select())})):(this[0].setSelectionRange?(a=this[0].selectionStart,b=this[0].selectionEnd):document.selection&&document.selection.createRange&&(c=document.selection.createRange(),a=0-c.duplicate().moveStart("character",-1e5),b=a+c.text.length),{begin:a,end:b})},unmask:function(){return this.trigger("unmask")},mask:function(c,g){var h,i,j,k,l,m,n,o;if(!c&&this.length>0){h=a(this[0]);var p=h.data(a.mask.dataName);return p?p():void 0}return g=a.extend({autoclear:a.mask.autoclear,placeholder:a.mask.placeholder,completed:null},g),i=a.mask.definitions,j=[],k=n=c.length,l=null,a.each(c.split(""),function(a,b){"?"==b?(n--,k=a):i[b]?(j.push(new RegExp(i[b])),null===l&&(l=j.length-1),k>a&&(m=j.length-1)):j.push(null)}),this.trigger("unmask").each(function(){function h(){if(g.completed){for(var a=l;m>=a;a++)if(j[a]&&C[a]===p(a))return;g.completed.call(B)}}function p(a){return g.placeholder.charAt(a<g.placeholder.length?a:0)}function q(a){for(;++a<n&&!j[a];);return a}function r(a){for(;--a>=0&&!j[a];);return a}function s(a,b){var c,d;if(!(0>a)){for(c=a,d=q(b);n>c;c++)if(j[c]){if(!(n>d&&j[c].test(C[d])))break;C[c]=C[d],C[d]=p(d),d=q(d)}z(),B.caret(Math.max(l,a))}}function t(a){var b,c,d,e;for(b=a,c=p(a);n>b;b++)if(j[b]){if(d=q(b),e=C[b],C[b]=c,!(n>d&&j[d].test(e)))break;c=e}}function u(){var a=B.val(),b=B.caret();if(o&&o.length&&o.length>a.length){for(A(!0);b.begin>0&&!j[b.begin-1];)b.begin--;if(0===b.begin)for(;b.begin<l&&!j[b.begin];)b.begin++;B.caret(b.begin,b.begin)}else{for(A(!0);b.begin<n&&!j[b.begin];)b.begin++;B.caret(b.begin,b.begin)}h()}function v(){A(),B.val()!=E&&B.change()}function w(a){if(!B.prop("readonly")){var b,c,e,f=a.which||a.keyCode;o=B.val(),8===f||46===f||d&&127===f?(b=B.caret(),c=b.begin,e=b.end,e-c===0&&(c=46!==f?r(c):e=q(c-1),e=46===f?q(e):e),y(c,e),s(c,e-1),a.preventDefault()):13===f?v.call(this,a):27===f&&(B.val(E),B.caret(0,A()),a.preventDefault())}}function x(b){if(!B.prop("readonly")){var c,d,e,g=b.which||b.keyCode,i=B.caret();if(!(b.ctrlKey||b.altKey||b.metaKey||32>g)&&g&&13!==g){if(i.end-i.begin!==0&&(y(i.begin,i.end),s(i.begin,i.end-1)),c=q(i.begin-1),n>c&&(d=String.fromCharCode(g),j[c].test(d))){if(t(c),C[c]=d,z(),e=q(c),f){var k=function(){a.proxy(a.fn.caret,B,e)()};setTimeout(k,0)}else B.caret(e);i.begin<=m&&h()}b.preventDefault()}}}function y(a,b){var c;for(c=a;b>c&&n>c;c++)j[c]&&(C[c]=p(c))}function z(){B.val(C.join(""))}function A(a){var b,c,d,e=B.val(),f=-1;for(b=0,d=0;n>b;b++)if(j[b]){for(C[b]=p(b);d++<e.length;)if(c=e.charAt(d-1),j[b].test(c)){C[b]=c,f=b;break}if(d>e.length){y(b+1,n);break}}else C[b]===e.charAt(d)&&d++,k>b&&(f=b);return a?z():k>f+1?g.autoclear||C.join("")===D?(B.val()&&B.val(""),y(0,n)):z():(z(),B.val(B.val().substring(0,f+1))),k?b:l}var B=a(this),C=a.map(c.split(""),function(a,b){return"?"!=a?i[a]?p(b):a:void 0}),D=C.join(""),E=B.val();B.data(a.mask.dataName,function(){return a.map(C,function(a,b){return j[b]&&a!=p(b)?a:null}).join("")}),B.one("unmask",function(){B.off(".mask").removeData(a.mask.dataName)}).on("http://develov2.beget.tech/js/focus.mask",function(){if(!B.prop("readonly")){clearTimeout(b);var a;E=B.val(),a=A(),b=setTimeout(function(){B.get(0)===document.activeElement&&(z(),a==c.replace("?","").length?B.caret(0,a):B.caret(a))},10)}}).on("http://develov2.beget.tech/js/blur.mask",v).on("http://develov2.beget.tech/js/keydown.mask",w).on("http://develov2.beget.tech/js/keypress.mask",x).on("http://develov2.beget.tech/js/input.mask paste.mask",function(){B.prop("readonly")||setTimeout(function(){var a=A(!0);B.caret(a),h()},0)}),e&&f&&B.off("http://develov2.beget.tech/js/input.mask").on("http://develov2.beget.tech/js/input.mask",u),A()})}})});
jQuery(function($){
 $(".phone_input").mask("+7 (999) 999-99-99");
 });
$(".popup_cons").click(function(){
    $(".popup1").css("display", "block");
});
$(".close1").click(function(){
    $(".popup").css("display", "none");
});
$(".close2").click(function(){
    $(".popup").css("display", "none");
}); 
document.addEventListener(
    "wpcf7mailsent",
    function (event) {
        $(".popup1").css("display", "none");
        $(".popup2").css("display", "none");
        $(".popup3").css("display", "none");
        $(".popup_last").css("display", "block");
        ym(69622291, "reachGoal", "form1");
        $(".close1").click(function () {
            $(".popup_last").css("display", "none");
        });
        $(".close2").click(function () {
            $(".popup_last").css("display", "none");
        });
    },
    false
);
document.addEventListener('DOMContentLoaded', (event) => {
    const priceFilterTitle = document.querySelector('.price-filter-title');
    const priceInputs = document.querySelector('.price-range-inputs');
    const priceSlider = document.querySelector('.price-slider');
    
    function togglePriceFilter() {
        if (priceInputs.style.display === 'none' || !priceInputs.style.display) {
            priceInputs.style.display = 'flex';
            priceSlider.style.display = 'block';
            priceFilterTitle.classList.add('active');
        } else {
            priceInputs.style.display = 'none';
            priceSlider.style.display = 'none';
            priceFilterTitle.classList.remove('active');
        }
    }

    // Переключаємо фільтр ціни при кліку на заголовок
    priceFilterTitle.addEventListener('click', togglePriceFilter);
});
function toggleFilter(filterId) {
    var filterContent = document.getElementById(filterId);
    var filter = filterContent.previousElementSibling; // Заголовок фільтру h3

    if (getComputedStyle(filterContent).display === 'none') {
        filterContent.style.display = 'block';
        filter.classList.add('active'); // Додаємо клас, щоб змінити іконку
    } else {
        filterContent.style.display = 'none';
        filter.classList.remove('active'); // Видаляємо клас
    }
}

// Очищення всіх фільтрів
function clearFilters() {
    document.querySelectorAll('.filter-content').forEach(content => {
        content.style.display = 'none'; // Приховуємо всі фільтри
        content.previousElementSibling.classList.remove('active'); // Знімаємо клас active
    });
}

// Переконайтеся, що ця функція викликається після завантаження всіх елементів
document.addEventListener('DOMContentLoaded', (event) => {
    // Прив'язуємо кліки для всіх фільтрів
    document.querySelectorAll('.filter-title').forEach(title => {
        title.addEventListener('click', () => toggleFilter(title.nextElementSibling.id));
    });
});


// Получаем элемент кнопки меню и само меню
var menuBtn = document.getElementById('menuBtn');
var headerMenu = document.querySelector('.header_menu');

// Добавляем слушатель событий на клик по кнопке
menuBtn.addEventListener('click', function() {
    // Переключаем класс 'active', который показывает или скрывает меню
    menuBtn.classList.toggle('active');
    headerMenu.classList.toggle('active'); // Предполагаем, что у меню также есть класс 'active'
});
