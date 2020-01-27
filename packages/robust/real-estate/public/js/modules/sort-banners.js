;
(function ($, FRW, window, document, undefined) {
    "use strict";
    FRW.Sortable = {
        init: function(elem){
            elem.nestable({
                placeClass: 'sort-container__placeholder',
                rootClass: 'sort-container__root',
                listClass: 'sort-container__list',
                itemClass: 'sort-container__item',
                handleClass: 'sort-container__handle'
            });

            elem.on('change', function(e) {
                FRW.Sortable.update(elem);
            });

            FRW.Sortable.update(elem);
        },
        update: function(elem){
            let itemsElem = $(elem).find('.sort-container__item');
            let item_to_update = $('.sort-container__list').data('update-item');
            let items = [];
            $.each(itemsElem, function(index, item){
                items.push($(item).data('id'));
            });
            $(`:input[name=${item_to_update}]`).val(items.join(","));
        }
    };

    $(function () {
        if($(".sort-container__root").length === 0){
            return;
        }

        FRW.Sortable.init($('.sort-container__root'));
    });
}(jQuery, FRW, window, document));
