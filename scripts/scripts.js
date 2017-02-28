/**
 * Created by andreas on 28/02/2017.
 */
function calculatePrice(chipsOrders) {
    var getFormValue = document.getElementById("orderAmount");
    var amountOfItems = getFormValue.options[getFormValue.selectedIndex].value;

    var getFormValue = document.getElementById("priceOfItem");
    var priceOfItems = getFormValue.options[getFormValue.selectedIndex].value;

    amountOfItems = parseInt(amountOfItems);
    priceOfItems = parseFloat(priceOfItems);

    var sumOfOrders = amountOfItems * priceOfItems;

    document.getElementById("sumOfOrder").value = sumOfOrders;
}