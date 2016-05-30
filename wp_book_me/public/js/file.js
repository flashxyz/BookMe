


function test1() {
    return true;
}

function convertTime(houreStart, minStart) {
    var strTimeStart;
    if (houreStart < 10) {
        if (minStart < 10)
            strTimeStart = '0' + houreStart + ':' + minStart + '0';
        else
            strTimeStart = '0' + houreStart + ':' + minStart;
    }
    else {
        if (minStart < 10)
            strTimeStart = houreStart + ':' + minStart + '0';
        else
            strTimeStart = houreStart + ':' + minStart;
        return strTimeStart;
    }

}

function displayCheckboxes(servicesArr) {
    var checkboxes = "<tr class='col-sm-12'>";

    for (var i = 0; i < servicesArr.length; i++) {
        if (i % 3 == 0 && i > 0)
            checkboxes += "</tr><tr class='col-sm-12'>"

        checkboxes += "<td class='checkbox-inline checkbox'> <label><input type='checkbox' value = '0' >" +
            " <span class='cr'><i class='cr-icon glyphicon glyphicon-ok'></i></span>" +
            servicesArr[i] +
            " </label></td>";

    }
    checkboxes += "</tr>"

    return checkboxes;
}