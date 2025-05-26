
var keyFlag = "";
var isGetSuccess = false;

function getMFS100Info() {
	keyFlag = "";
	return GetMFS100Client("info");
}

function getMFS100KeyInfo(key) {
	keyFlag = key;
	if (!PrepareScanner()) {
		return getFalseRes();
	}
	var MFS100Request = {
		"Key": key,
	};
	var jsondata = JSON.stringify(MFS100Request);
	return PostMFS100Client("keyinfo", jsondata);
}

function captureFinger(quality, timeout) {
	if (!PrepareScanner()) {
		return getFalseRes();
	}
	var MFS100Request = {
		"Quality": quality,
		"Timeout": timeout
	};
	var jsondata = JSON.stringify(MFS100Request);
	return PostMFS100Client("capture", jsondata);
}

function verifyFinger(ProbFMR, GalleryFMR) {
	if (!PrepareScanner()) {
		return getFalseRes();
	}
	var MFS100Request = {
		"ProbTemplate": ProbFMR,
		"GalleryTemplate": GalleryFMR,
		"BioType": FMR
	};
	var jsondata = JSON.stringify(MFS100Request);
	return PostMFS100Client("verify", jsondata);
}

function matchFinger(quality, timeout, GalleryFMR) {
	if (!PrepareScanner()) {
		return getFalseRes();
	}
	var MFS100Request = {
		"Quality": quality,
		"Timeout": timeout,
		"GalleryTemplate": GalleryFMR,
		"BioType": FMR
	};
	var jsondata = JSON.stringify(MFS100Request);
	return PostMFS100Client("match", jsondata);
}

function getPidData(BiometricArray) {
	if (!PrepareScanner()) {
		return getFalseRes();
	}
	var res = new MFS100Request(BiometricArray);
	var jsondata = JSON.stringify(res);
	return PostMFS100Client("getpiddata", jsondata);
}

function getProtoPidData(BiometricArray) {
	if (!PrepareScanner()) {
		return getFalseRes();
	}
	var res = new MFS100Request(BiometricArray);
	var jsondata = JSON.stringify(res);
	return PostMFS100Client("getprotopiddata", jsondata);
}

function getRbdData(BiometricArray) {
	if (!PrepareScanner()) {
		return getFalseRes();
	}
	var res = new MFS100Request(BiometricArray);
	var jsondata = JSON.stringify(res);
	return PostMFS100Client("getrbddata", jsondata);
}

function getProtoRbdData(BiometricArray) {
	if (!PrepareScanner()) {
		return getFalseRes();
	}
	var res = new MFS100Request(BiometricArray);
	var jsondata = JSON.stringify(res);
	return PostMFS100Client("getprotorbddata", jsondata);
}

function PostMFS100Client(method, jsondata){
	var res;
	$.support.cors = true;
	var httpStatus = false;

	$.ajax({
		type: "POST",
        async: false,
        crossDomain: true,
        url: baseurl + method,
        contentType: "application/json; charset=utf-8",
        data: jsonData,
        dataType: "json",
        processData: false,
        success: function (data) {
            httpStatus = true;
            res = { httpStatus: httpStatus, data: data };
        },
        error: function (jqXHR, ajaxOptions, thrownError) {
            res = { httpStatus: httpStatus, err: getHttpError(jqXHR) };
        },
	});
	return res;
}


function getMFS100Client(method){
	var res;
	$.support.cors = true;
	var httpStatus = false;

	$.ajax({
		type: "POST",
        async: false,
        crossDomain: true,
        url: baseurl + method,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        processData: false,
        success: function (data) {
            httpStatus = true;
            res = { httpStatus: httpStatus, data: data };
        },
        error: function (jqXHR, ajaxOptions, thrownError) {
            res = { httpStatus: httpStatus, err: getHttpError(jqXHR) };
        },
	});
	return res;
}

function getHttpError(jqXHR){
	var err = "Unhandled Exception";
    if (jqXHR.status === 0) {
        err = 'Service Unavailable';
    } else if (jqXHR.status == 404) {
        err = 'Requested page not found';
    } else if (jqXHR.status == 500) {
        err = 'Internal Server Error';
    } else if (thrownError === 'parsererror') {
        err = 'Requested JSON parse failed';
    } else if (thrownError === 'timeout') {
        err = 'Time out error';
    } else if (thrownError === 'abort') {
        err = 'Ajax request aborted';
    } else {
        err = 'Unhandled Error';
    }
    return err;
}

function Biometric(BioType, BiometricData, Pos, Nfiq, Na) {
	this.BioType = BioType;
	this.BiometricData = BiometricData;
	this.Pos = Pos;
	this.Nfiq = Nfiq;
	this.Na = Na;
}

function MFS100Request(BiometricArray) {
	this.Biometrics = BiometricArray;
}

function PrepareScanner() {
	try{
		if (!isGetSuccess) {
            var resInfo = getMFS100Client("info");
            if (!resInfo.httpStatus) {
                return false;
            }
            else {
                isGetSuccess = true;
            }
           
            if (KeyFlag !=  null && KeyFlag != 'undefined' && KeyFlag.length > 0) {
                var MFS100Request = {
                    "Key": KeyFlag,
                };
                var jsondata = JSON.stringify(MFS100Request);
                PostMFS100Client("keyinfo", jsondata);
            }
        }

	} catch(e){

	}
	return true;
}

function getFalseRes() {
	var res;
	res = { httpStatus: false, err: "Error while calling service" };
	return res;
}