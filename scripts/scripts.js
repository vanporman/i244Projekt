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

//<---kogumüügi tabel algus--->
function showAllSales() {
    getRequest(
        '../kuuku/php_scripts/showSalesSum.php',
        showOrdersAS,
        drawErrorAS
    );
    return false;
}

function drawErrorAS() {
    var containerRH = document.getElementById('SumOfSales');
    containerRH.innerHTML = 'Bummer: there was an error!';
}

function showOrdersAS(responseText) {
    var containerRH = document.getElementById('sumOfSales');
    containerRH.innerHTML = responseText;
}
//<---kogumüügu tabel lõpp--->

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
    var containerRH = document.getElementById('retailSale');
    containerRH.innerHTML = 'Bummer: there was an error!';
}

function showOrdersRH(responseText) {
    var containerRH = document.getElementById('retailSale');
    containerRH.innerHTML = responseText;
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
    var containerWS = document.getElementById('wholeSale');
    containerWS.innerHTML = 'Bummer: there was an error!';
}

function showOrdersWS(responseText) {
    var containerWS = document.getElementById('wholeSale');
    containerWS.innerHTML = responseText;
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
    var containerWS = document.getElementById('fairSale');
    containerWS.innerHTML = 'Bummer: there was an error!';
}

function showOrdersFS(responseText) {
    var containerWS = document.getElementById('fairSale');
    containerWS.innerHTML = responseText;
}
//<---laadamüügu tabel lõpp--->

//<---tellimuste tabel algus--->
function showOrdersHistory() {
    getRequest(
        '../kuuku/php_scripts/showOrdersHistory.php',
        showOrdersOH,
        drawErrorOH
    );
    return false;
}

function drawErrorOH() {
    var containerOH = document.getElementById('ordersInLine');
    containerOH.innerHTML = 'Bummer: there was an error!';
}

function showOrdersOH(responseText) {
    var containerOH = document.getElementById('ordersInLine');
    containerOH.innerHTML = responseText;
}
//<---tellimuste tabel lõpp--->

//<---jaetellimuste tabel algus--->
function showRetailOrders() {
    getRequest(
        '../kuuku/php_scripts/showRetailOrders.php',
        showOrdersRO,
        drawErrorRO
    );
    return false;
}

function drawErrorRO() {
    var containerRO = document.getElementById('ordersRetail');
    containerRO.innerHTML = 'Bummer: there was an error!';
}

function showOrdersRO(responseText) {
    var containerRO = document.getElementById('ordersRetail');
    containerRO.innerHTML = responseText;
}
//<---jaetellimuste tabel lõpp--->

//<---hulgitellimuste tabel algus--->
function showWholesaleOrders() {
    getRequest(
        '../kuuku/php_scripts/showWholesaleOrders.php',
        showOrdersWO,
        drawErrorWO
    );
    return false;
}

function drawErrorWO() {
    var containerWO = document.getElementById('ordersWholesale');
    containerWO.innerHTML = 'Bummer: there was an error!';
}

function showOrdersWO(responseText) {
    var containerWO = document.getElementById('ordersWholesale');
    containerWO.innerHTML = responseText;
}
//<---hulgitellimuste tabel lõpp--->

//<---demo tabel algus--->
function showDemoPacks() {
    getRequest(
        '../kuuku/php_scripts/showDemos.php',
        showOrdersDP,
        drawErrorDP
    );
    return false;
}

function drawErrorDP() {
    var containerDP = document.getElementById('demoPacks');
    containerDP.innerHTML = 'Bummer: there was an error!';
}

function showOrdersDP(responseText) {
    var containerDP = document.getElementById('demoPacks');
    containerDP.innerHTML = responseText;
}
//<---demo tabel lõpp--->


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