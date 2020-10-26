document.addEventListener( "DOMContentLoaded", () => {
    if ( pagenow == undefined ) {
        return;
    }

    if ( pagenow === 'product' ) {
        const __table = document.getElementById( 'praxiv-table' );
        const __addMore = document.getElementById( 'praxiv-add-more' );
        const __house = document.getElementById( 'house_number' );
        const __per_char_price = document.querySelector('.per_char_price');
        
        if ( __table && __addMore && __house && __per_char_price ) {
            const __tableBody = __table.querySelector('tbody');
            __addMore.addEventListener( 'click', () => {
                __tableBody.insertAdjacentHTML( 'beforeend', '<tr><td><input type="number" step="0.1" name="house_distance[]"></td><td><input type="number" step="0.1" name="house_cost[]"></td><td class="text-center"><span class="color-red dashicons dashicons-dismiss praxiv-remove"></span></td></tr>' );
            });

            __house.onchange = function( e ) {
                if ( __house.checked ) {
                    __table.classList.remove('display-none');
                    __per_char_price.classList.remove('display-none');
                } else {
                    __table.classList.add('display-none');
                    __per_char_price.classList.add('display-none');
                }
            };

            __tableBody.addEventListener( 'click', ( e ) => {
                if ( e.target.classList.contains( 'praxiv-remove' ) ) {
                    
                    e.target.parentElement.parentElement.parentElement.removeChild(e.target.parentElement.parentElement);
                }
            });
        }

    }

});