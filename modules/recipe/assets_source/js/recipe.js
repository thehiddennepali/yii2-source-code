/**
 * Created by nurbek on 10/11/16.
 */


$('body').on('change keyup', '#recipeForm input, #recipeForm select', function () {

    var $tr = $(this).parents('tr');
    var item_id = $tr.find('td').eq(0).find('select').val();
    var amount = $tr.find('td').eq(1).find('input').val();
    var unit = $tr.find('td').eq(1).find('select').val();
    var $cost = $tr.find('td').eq(2);

    $.ajax({
                url: baseUrl+'/item/item/get-converted-pound-price',
                data:{item_id:item_id, amount:amount, unit:unit },
                success:function(response)
                {
                    $cost.data('cost', response.price);
                    $cost.html(response.priceAsCurrency);

                    var total_recipe_cost = 0;
                    $('.ingredient-cost').each(function () {
                        var cost = $(this).data('cost') || 0;
                        total_recipe_cost+= parseFloat(cost);
                        $('[name="Recipe[total_recipe_cost]"]').val(total_recipe_cost.toFixed(2));
                        $('[name="Recipe[selling_price]"]').trigger('keyup');
                    })
                }
        });
});

$('[name="Recipe[selling_price]"]').keyup(function(){
    var selling_price = $(this).val() || 0;
    selling_price = parseFloat(selling_price);
    var total_recipe_cost = $('[name="Recipe[total_recipe_cost]"]').val() || 0;
    total_recipe_cost = parseFloat(total_recipe_cost);

    $('[name="Recipe[profit]"]').val((selling_price - total_recipe_cost).toFixed(2));
    if(selling_price!=0)
        $('[name="Recipe[cost_percent]"]').val( (total_recipe_cost*100 / selling_price).toFixed(2));
});






$('body').on('click', '.removePercent', function () {
    var i = $(this).data('i');
    $('#recipeForm').yiiActiveForm('remove', 'ingredient-'+i+'-item_id');
    $('#recipeForm').yiiActiveForm('remove', 'ingredient-'+i+'-amount');
    $('#recipeForm').yiiActiveForm('remove', 'ingredient-'+i+'-unit');
    $(this).parents('tr').remove();
});

$('body').on('click', '.addPercent', function () {

    var $this = $(this);
    var i = $(this).parents('table').find('tbody tr').length;


    $.ajax({
                url: baseUrl+'/recipe/recipe/ingredient',
                data:{index:i},
                success:function(template)
                {
                    $this.parents('table').find('tbody tr:last').after(template);
                }
        });





    $('#recipeForm').yiiActiveForm('add',
        {
            "id": "ingredient-"+i+"-item_id",
            "name": "["+i+"]item_id",
            "container": ".field-ingredient-"+i+"-item_id",
            "input": "#ingredient-"+i+"-item_id",
            "enableAjaxValidation": true,
            "validate": function (attribute, value, messages, deferred, $form) {
                yii.validation.required(value
                    , messages, {"message": "Item ID cannot be blank."});
                yii.validation.number(value, messages, {
                    "pattern": /^\s*[+-]?\d+\s*$/, "message": "Item ID must be an integer.", "skipOnEmpty": 1
                });
            }
        }
    );

    $('#recipeForm').yiiActiveForm('add',
        {
            "id": "ingredient-"+i+"-amount"
            ,
            "name": "["+i+"]amount",
            "container": ".field-ingredient-"+i+"-amount",
            "input": "#ingredient-"+i+"-amount",
            "enableAjaxValidation": true,
            "validate": function (attribute, value, messages, deferred, $form) {
                yii.validation.required(value
                    , messages, {"message": "Amount cannot be blank."});
                yii.validation.number(value, messages, {
                    "pattern": /^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/,
                    "message": "Amount must be a number.",
                    "skipOnEmpty": 1
                });
            }
        }
    );

    $('#recipeForm').yiiActiveForm('add',
        {
            "id": "ingredient-"+i+"-unit",
            "name": "["+i+"]unit",
            "container": ".field-ingredient-"+i+"-unit",
            "input": "#ingredient-"+i+"-unit"
            ,
            "enableAjaxValidation": true,
            "validate": function (attribute, value, messages, deferred, $form) {
                yii.validation
                    .required(value, messages, {"message": "Unit cannot be blank."});
                yii.validation.string(value, messages
                    , {
                        "message": "Unit must be a string.",
                        "max": 45,
                        "tooLong": "Unit should contain at most 45 characters."
                        ,
                        "skipOnEmpty": 1
                    });
            }
        }
    );

});
