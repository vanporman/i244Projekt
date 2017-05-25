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
//<---jaemüügi tabel algus--->
function showRetailHistory() {
    getRequest(
        '../kuuku/php_scripts/showRetailHistory.php',
        showOrdersRH,
        drawErrorRH
    );
    return false;
}

function drawErrorRH() {
    var container = document.getElementById('retailSale');
    container.innerHTML = 'Bummer: there was an error!';
}

function showOrdersRH(responseText) {
    var container = document.getElementById('retailSale');
    container.innerHTML = responseText;
}
//<---jaemüügu tabel lõpp--->

//<---hulgimüügi tabel algus--->
function showWholesaleHistory() {
    getRequest(
        '../kuuku/php_scripts/showWholesaleHistory.php',
        showOrdersWS,
        drawErrorWS
    );
    return false;
}

function drawErrorWS() {
    var container = document.getElementById('wholeSale');
    container.innerHTML = 'Bummer: there was an error!';
}

function showOrdersWS(responseText) {
    var container = document.getElementById('wholeSale');
    container.innerHTML = responseText;
}
//<---hukgimüügu tabel lõpp--->

//<---laadamüügi tabel algus--->
function showFairsaleHistory() {
    getRequest(
        '../kuuku/php_scripts/showFairsaleHistory.php',
        showOrdersFS,
        drawErrorFS
    );
    return false;
}

function drawErrorFS() {
    var container = document.getElementById('fairSale');
    container.innerHTML = 'Bummer: there was an error!';
}

function showOrdersFS(responseText) {
    var container = document.getElementById('fairSale');
    container.innerHTML = responseText;
}
//<---laadamüügu tabel lõpp--->

// helper function for cross-browser request object
function getRequest(url, success, error) {
    var req = false;
    try{
        // most browsers
        req = new XMLHttpRequest();
    } catch (e){
        // IE
        try{
            req = new ActiveXObject("Msxml2.XMLHTTP");
        } catch(e) {
            // try an older version
            try{
                req = new ActiveXObject("Microsoft.XMLHTTP");
            } catch(e) {
                return false;
            }
        }
    }
    if (!req) return false;
    if (typeof success != 'function') success = function () {};
    if (typeof error!= 'function') error = function () {};
    req.onreadystatechange = function(){
        if(req.readyState == 4) {
            return req.status === 200 ?
                success(req.responseText) : error(req.status);
        }
    }
    req.open("GET", url, true);
    req.send(null);
    return req;
}

