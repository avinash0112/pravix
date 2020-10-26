var varPrice = null;
var price = null;
document.addEventListener( 'DOMContentLoaded', () => {
    if ( praxiv_obj == undefined ) {
        return;
    }
    var varaiation = document.querySelector( '.variations select');
    price = document.querySelector('.price');
    if ( varaiation ) {
        
        jQuery('.variations select').on('change', function( e ) {
            setTimeout(function () {
                varPrice = document.getElementById('pravix-product-price');
                price = document.querySelector('.woocommerce-variation-price .price');
                praxiv_obj.price = filterNum(price.innerText);
                intializeEvent();
            }, 1000);
        });
    }
    intializeEvent();

});
const filterNum = (str) => {
    const numericalChar = new Set([ ".",",","0","1","2","3","4","5","6","7","8","9" ]);
    str = str.split("").filter(char => numericalChar.has(char)).join("");
    return str;
}
  
var intializeEvent = () => {
    const house_div = document.getElementById('house_div');
    const per_char = document.getElementById('praxiv-per-char');
    const symbol = document.querySelector('.woocommerce-Price-currencySymbol').innerHTML;
    const house_distance = document.getElementById( 'house_distance');
    var price_val, price_house;
    price_house = 0;
    const house_total_cost = document.getElementById('house_total_cost');
    if ( house_div && per_char && house_distance ) {
        per_char.addEventListener( 'blur', ( e) => {
            if ( per_char.value.length > 10 ) {
                per_char.value = per_char.value.slice(0,10);
                price_val = parseFloat( per_char.value.length * praxiv_obj.per_char_price ) + parseFloat( praxiv_obj.price ) + price_house;
                price.innerHTML = '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">' + symbol + '</span>' + price_val +'</span>';
            }  else {
                price_val = parseFloat( per_char.value.length * praxiv_obj.per_char_price ) + parseFloat( praxiv_obj.price ) + price_house;
                price.innerHTML = '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">' + symbol + '</span>' + price_val +'</span>';
            }
            house_total_cost.value = price_val;
        });

        per_char.addEventListener( 'keyup', ( e) => {
            if ( per_char.value.length >= 0 && per_char.value.length <10) {
                price_val = parseFloat( per_char.value.length * praxiv_obj.per_char_price ) + parseFloat( praxiv_obj.price ) + price_house;
                price.innerHTML = '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">' + symbol + '</span>' + price_val +'</span>';
                house_total_cost.value = price_val;
            } 
        });

        house_distance.onchange = function( e ) {
            var option   = house_distance.options;
            var distnace = house_distance.options[ house_distance.selectedIndex].value;
            praxiv_obj.house_distance.forEach( (element, i) => {
                if ( element == distnace ) {
                    price_house = parseFloat( praxiv_obj.house_cost[ i ] );
                    price_val = ( parseFloat( per_char.value.length * praxiv_obj.per_char_price ) + parseFloat( praxiv_obj.price ) + price_house );
                    price.innerHTML = '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">' + symbol + '</span>' + price_val + '</span>';
                    house_total_cost.value = price_val;
                } else {
                    price_house = 0;
                    price_val = ( parseFloat( per_char.value.length * praxiv_obj.per_char_price ) + parseFloat( praxiv_obj.price ) + price_house );
                    price.innerHTML = '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">' + symbol + '</span>' + price_val + '</span>';
                    house_total_cost.value = price_val;
                }
            });
        }
    }
    
}