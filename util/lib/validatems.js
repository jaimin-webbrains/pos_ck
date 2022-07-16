class Validatems {
    static prepareData(form, array) {
        var formElements = {};
        if (form) {
            $(form + ' input, ' + form + ' select, ' + form + ' textarea').each(function (index) {
                var element = $(this);
                formElements[element.attr('id')] = element.val();
            });
        }
        if (array) {
            for (var index in array) {
                formElements[index] = array[index];
            }
        }
        return formElements;
    }

    static validateAndSubmit(url, defaultElement, array) {
        var result;
        $.ajax({
            type: 'POST',
            url: url,
            data: {defaultElement: defaultElement, dataArray: array},
            dataType: 'json',
            async: false,
            success: function (data) {
                result = data;
//                Validatems.displayResults(data);
            },
            error: function (xhr) {
                $.alert(xhr.responseText);
            }
        });
        return result;
    }

    static validate(validations) {
        var errors = [];
        for (var index in validations) {
            if (validations[index] !== "") {
//                if (bool) {
//                    $("#" + index).after("<p style='color:red;'>" + validations[index] + "</p>");
//                }
                $("#" + index).css({"border": "1px solid red"});
                if (validations[index]) {
                    errors.push(validations[index]);
                }
            } else {
                $("#" + index).css({"border": "1px solid #ccc"});
            }
        }

        return errors;
    }

    static displayResults(data) {
        if (data['message'] === "sucsess") {
            $.alert({
                icon: 'fa fa-check-circle',
                backgroundDismiss: true,
                type: 'green',
                title: 'Succsess!',
                content: "Succsessfully done the operation"
            });
            return true;
        } else {
            var errors = Validatems.validate(data['validations']);
            if (data['message'] === "val_error") {
                $.alert({
                    icon: 'fa fa-exclamation-circle',
                    backgroundDismiss: true,
                    type: 'red',
                    title: 'Validation error!',
                    content: errors.join("</br>")
                });
                return false;
            } else {
                $.alert({
                    icon: 'fa fa-exclamation-circle',
                    backgroundDismiss: true,
                    type: 'red',
                    title: 'Failed!',
                    content: "Something went wrong..."+JSON.stringify(data['message']) 
                });
                return false;
            }
        }
    }

}
