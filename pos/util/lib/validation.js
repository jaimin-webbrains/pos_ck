
class Validation {

    static validatePrice(string) {
        return new RegExp("^[0-9]+(\.[0-9]{0,2})?$").test(string);
    }
    
    static validateKg(string) {
        return new RegExp("^[0-9]+(\.[0-9]{0,3})?$").test(string);
    }

    static validateOnlyNumber(string) {
        return new RegExp("^[0-9]+$").test(string);
    }
    
    static validateDate(string) {
        return new RegExp("^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$").test(string);
    }
    
    static validateDateTime(string) {
        return new RegExp("^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (0[1-9]|1[0-9]|2[0-4]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])$").test(string);
    }

    static valEmail(string) {
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        return reg.test(string);
    }

//    static privilegeByModuleAction(module, action) {
//        var result;
//        $.ajax({
//            type: 'POST',
//            url: "../user_privileges_authenticate.php",
//            data: {privilege_by_module_action: true, module: module, action: action},
//            dataType: 'json',
//            async: false,
//            success: function (data) {
//                result = data;
//            },
//            error: function (xhr) {
//                alert(xhr.responseText);
//            }
//        });
//        return result;
//    }

}