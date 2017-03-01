/**
 * Created by andreas on 28/02/2017.
 */

function calculatePrice(chipsOrders) {
    var amountOfItems = document.getElementById("orderAmount").value;

    var getFormValueOfItems = document.getElementById("priceOfItem");
    var priceOfItems = getFormValueOfItems.options[getFormValueOfItems.selectedIndex].value;

    amountOfItems = parseFloat(amountOfItems);
    priceOfItems = parseFloat(priceOfItems);

    var sumOfOrders = amountOfItems * priceOfItems;

    document.getElementById("sumOfOrder").value = sumOfOrders;
}

