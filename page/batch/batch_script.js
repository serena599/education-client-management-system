url = "batch_action.php";
modal_body = "modal_md_body";
modal = "md";

var action_data = {
    'url': url,
    'div': modal_body,
    'load': 0
};

function get_batch_form(type, id = 0) {
    if (type == "insert") {
        header = "Add Batch";
        data_key = "add_batch_form";
        val = 1;
    } else if (type == "update") {
        header = "Update Batch";
        data_key = "update_batch_form";
        val = id;
    } else {
        header = "Delete Batch";
        data_key = "delete_batch_form";
        val = id;
    }

    modal_open(modal, header);
    loader(modal_body);

    var data = {
        [data_key]: val
    }

    get_ajax(action_data, data);
}

function show_batch_error(message) {
    $("#" + modal_body + " .batch-form-error").remove();
    $("#" + modal_body).prepend("<div class='batch-form-error'>" + message + "</div>");
}

function clear_batch_error() {
    $("#" + modal_body + " .batch-form-error").remove();
}

function batch_action(type, id = 0) {

    delete_type = 0;
    if (type == "insert") {
        data_key = "insert_batch";
        val = 0;
    } else if (type == "update") {
        data_key = "update_batch";
        val = id;
    } else {
        data_key = "delete_batch";
        val = id;
        delete_type = 1;
    }

    if (delete_type == 0) {
        data_val = get_data();
        error = filter_data(data_val);
    } else {
        var data_val = {
            'id': val
        }
        error = 0;
    }

    var data = {
        [data_key]: data_val
    }

    if (error == 0) {
        action_data['load'] = 1;
        loader(modal_body);
        get_ajax(action_data, data);
    }
}


function get_data() {
    var data_val = {
        'id': val,
        'name': get_value("batch_name"),
        'start': get_value("batch_start"),
        'end': get_value("batch_end"),
        'day':get_checkbox_value('batch_day[]')
    }

    return data_val;
}

function filter_data(data) {
    name = data['name'];
    start = data['start'];
    end = data['end'];

    error = 0;
    if (name == "") {
        show_batch_error("Please enter a batch name.");
        error = 1;
    } else if (start == "") {
        show_batch_error("Please enter a start time.");
        error = 1;
    } else if (end == "") {
        show_batch_error("Please enter an end time.");
        error = 1;
    } else {
        clear_batch_error();
    }
    return error;
}
