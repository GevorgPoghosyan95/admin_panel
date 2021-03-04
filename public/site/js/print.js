function onClick() {
                var doc = new jsPDF('p','pt','a4');
                           var pdfInternals = doc.internal;
            var pdfPageSize = pdfInternals.pageSize;
            var pdfPageWidth = pdfPageSize.width;
            var pdfPageHeight = pdfPageSize.height;

            var partialSize = 10;
            var contentSize = 0;
            var marginTop = 20;
            var index = 0;

var utf_8_string_to_render = $('#content').html();

Promise.all(
[
    new Promise(function (resolve)
    {
        var temp = document.createElement("div");

        temp.id = "temp";
        temp.style = "color: black;margin:0px;font-size:16px;";
        phrase = utf_8_string_to_render;
        temp.innerHTML= phrase;
        //need to render element, otherwise it won't be displayed
        document.body.appendChild(temp);

        html2canvas($("#temp"), {
        onrendered: function(canvas) {
            marginTop += canvas.height/ (canvas.width / pdfPageHeight + (pdfPageWidth / pdfPageHeight) - 0.05);

                $("#temp").remove();
            resolve(canvas.toDataURL('image/png'));
        },
        });
    })
]).then(function (am_text) {

    doc.addImage(am_text[0], "jpeg", 20, 0, pdfPageWidth-20, 0);

    doc.save('Document.pdf');
    });



};

    function printContent() {
        var divContents = $("#content").html();
        var printWindow = window.open('', '', 'height=400,width=800');
        printWindow.document.write('<html><head>');
        printWindow.document.write('</head><body >');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
