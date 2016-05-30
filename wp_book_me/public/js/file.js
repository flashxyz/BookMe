


function test1() {
    return true;
}

function convertTime(houreStart, minStart) {
    var strTimeStart;
    if (houreStart < 10)
        if (minStart < 10)
            strTimeStart = '0' + houreStart + ':' + minStart + '0';
        else
            strTimeStart = '0' + houreStart + ':' + minStart;
    else if (minStart < 10)
        strTimeStart = houreStart + ':' + minStart + '0';
    else
        strTimeStart = houreStart + ':' + minStart;
    return strTimeStart;
}

