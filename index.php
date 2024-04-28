<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.02.min.css">
</head>

<body>
    <div class="autoComplete_wrapper">
        <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" autocapitalize="off">
        <input type="rate" id="rate">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
    <script>
        var products = [];
        var names = [];
        var auto
        fetch("http://localhost/invoice-system/api/allProduct.php?bid=1")
            .then(res => res.json())
            .then(data => {
                console.log(data);
                products = data
                names = data.map(d => d.product_name);
                setupAutoComplete();
            })
            .catch(e => console.log(e))

        function setupAutoComplete() {

            const autoCompleteJS = new autoComplete({
                placeHolder: "Search for Food...",
                data: {
                    src: names
                },
                resultItem: {
                    highlight: true,
                },
                events: {
                    input: {
                        selection: (event) => {
                            console.log(event);
                            let p = products.filter(p=>p.product_name==event.detail.selection.value)[0]
                    
                            document.getElementById('rate').value = p.rate
                            const selection = event.detail.selection.value;
                            autoCompleteJS.input.value = selection;
                        }
                    }
                }
            });
        }
    </script>
</body>


</html>