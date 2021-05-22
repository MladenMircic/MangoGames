
    $(document).ready(function(){
    $("#confirmOperation").click(function () {
        let ops = document.getElementsByClassName("operation");
        let types = document.getElementsByClassName("type");
        let operation = "";
        for (let i = 0; i < ops.length; i++) {
            if (ops[i].selected) {
                operation=ops[i].value;
                break;
            }
        }
        let type="";
        for (let i = 0; i < types.length; i++) {
            if (types[i].selected) {
                type=types[i].value;
                break;
            }
        }
        operationAndType(operation,type);

    });
});
