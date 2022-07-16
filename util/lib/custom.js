class FormOperations {
//    constructor(validation, form, id, array) {
//        this.form = form;
//        this.array = array;
//        this.validation = validation;
//        this.id = id;
//        confirmSave(this.form, this.array, this.validation, this.id);
//    }

    static confirmSave(validation, form, id, array) {
        if (validation) {
            if (id) {
                $.confirm({
                    icon: 'fa fa-question-circle',
                    type: 'green',
                    title: 'Save(Update)',
                    content: 'Are you sure you want to proceed ?',
                    buttons: {
                        yes: {
                            text: 'Yes',
                            btnClass: 'btn-green',
                            keys: ['enter'],
                            action: function () {
                                $(form).append($('<input />').attr('type', 'hidden').attr('name', "update").attr('value', "true"));
                                if (array) {
                                    $.each(array, function (index, value) {
                                        $(form).append($('<input />').attr('type', 'hidden').attr('name', index).attr('value', value));
                                    });
                                }
                                $(form).submit();
                            }
                        },
                        cancel: function () {
                        }
                    }
                });
            } else {
                $.confirm({
                    icon: 'fa fa-question-circle',
                    type: 'green',
                    title: 'Save',
                    content: 'Are you sure you want to proceed ?',
                    buttons: {
                        yes: {
                            text: 'Yes',
                            btnClass: 'btn-green',
                            keys: ['enter'],
                            action: function () {
                                $(form).append($('<input />').attr('type', 'hidden').attr('name', "save").attr('value', "true"));
                                if (array) {
                                    $.each(array, function (index, value) {
                                        $(form).append($('<input />').attr('type', 'hidden').attr('name', index).attr('value', value));
                                    });
                                }
                                $(form).submit();
                            }
                        },
                        cancel: function () {
                        }
                    }
                });
            }
        }
    }

    static confirmDelete(form, array) {
        $.confirm({
            icon: 'fa fa-warning',
            type: 'orange',
            title: 'Delete',
            content: 'Are you sure you want to proceed ?',
            buttons: {
                yes: {
                    text: 'Yes',
                    btnClass: 'btn-orange',
                    keys: ['enter'],
                    action: function () {
                        $(form).append($('<input />').attr('type', 'hidden').attr('name', "delete").attr('value', "true"));
                        if (array) {
                            $.each(array, function (index, value) {
                                $(form).append($('<input />').attr('type', 'hidden').attr('name', index).attr('value', value));
                            });
                        }
                        $(form).submit();
                    }
                },
                cancel: function () {
                }
            }
        });
    }

    static submitForm(validation, form, array) {
        if (validation) {
            $.confirm({
                icon: 'fa fa-question-circle',
                type: 'green',
                title: 'Submit',
                content: 'Are you sure you want to proceed ?',
                buttons: {
                    yes: {
                        text: 'Yes',
                        btnClass: 'btn-green',
                        keys: ['enter'],
                        action: function () {
                            if (array) {
                                $.each(array, function (index, value) {
//                                    if(isArray(value)){
//                                        $(form).append($('<input />').attr('type', 'hidden').attr('name', index+"[]").attr('value', value));
//                                    }else{
                                    $(form).append($('<input />').attr('type', 'hidden').attr('name', index).attr('value', value));
//                                    }
                                });
                            }

                            $(form).submit();
                        }
                    },
                    cancel: function () {
                    }
                }
            });
        }
    }

    static postForm(url, array) {
        var form = $('<form action="' + url + '" method="post"></form>');
        $.each(array, function (index, value) {
            $(form).append($('<input />').attr('type', 'hidden').attr('name', index).attr('value', value));
        });
        $('body').append(form);
        form.submit();
    }

//    static submitForm(form, array) {
//        $.each(array, function (index, value) {
//            $(form).append($('<input />').attr('type', 'hidden').attr('name', index).attr('value', value));
//        });
//
//        $(form).submit();
//    }
}


class UserPrivileges {

    static privilegeByModuleAction(url, module, action) {
        var result=false;
        $.ajax({
            type: 'POST',
            url: url,
            data: {privilege_by_module_action: true, module: module, action: action},
            dataType: 'json',
            async: false,
            success: function (data) {
                result = data;
            },
            error: function (xhr) {
                alert(xhr.responseText);
            }
        });
        return result;
    }

    static checkPrivilege(url, module, action) {
        var priv=this.privilegeByModuleAction(url, module, action);
        if (priv==1) {
            return true;
        } else {
            $.alert({
                icon: 'fa fa-exclamation-circle',
                backgroundDismiss: true,
                type: 'red',
                title: 'Access Denied !',
                content: 'You have no Privileges for the operation'
            });
            return false;
        }
    }

}




