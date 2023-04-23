<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="check.css"/>

    <title>Document</title>
</head>
<body>
<div class="container">
    <h2>Broken links are bad for business.
    </h2>
    <h1>Let WE CHECK Check track them down for you.
    </h1>

    <form action="" id="join-us">
        <div class="fields">
      <span>
       <input placeholder="Your Website URL" id="url_input" type="text" />
    </span>
        </div>
        <div class="submit">
            <input class="submit" value="Submit" id="submit" type="button" />
        </div>
    </form>

    <div class="response">

    </div>
</div>
<script src="jquery-3.6.0.min.js"></script>
<script>

    let api_key = "9d319ae707e8a8f06e0f4190bbe716676747d94e922b94b71e6f5c3b5a339e31";
    let api_url = "https://www.virustotal.com/api/v3/urls";

    // on submit click
    $("#submit").click(function () {

        let btn = $("#submit");

        function disable(){
            btn.attr("enabled", false);
            btn.attr("value", "checking...");
        }

        function enable(){
            btn.attr("enabled", true);
            btn.attr("value", "Submit");
        }

        // disable submit button
        disable();

        //getting entered url
        let entered_url = $("#url_input").val()

        // making request
        makeRequest("POST", api_url, {"url" : entered_url},

            // on request success
            function (response) {

                // if no links sent
                if(response.data === undefined){
                    alert("error no response.");
                    enable();
                    return;
                }

                // if no links sent
                if(response.data.links === undefined){
                    alert("error no links received.");
                    enable();
                    return;
                }

                // if no links sent
                if(response.data.links.self === undefined){
                    alert("error no links received.");
                    enable();
                    return;
                }

                //
                makeRequest("GET", response.data.links.self, {},

                    // on request success
                    function (response) {
                        $(".response").html(returnObjectHTML(response.data.attributes));
                        enable();
                    },

                    // on request failed
                    function () {
                        alert("submission failed, please check the entered URL");
                        enable();
                    }
                );

            },

            // on request failed
            function (){
                alert("submission failed, please check the entered URL");
                enable();
            }
        );

    });

    // making http request using jquery ajax function
    function makeRequest(type, url, values, success, fail){
        $.ajax({
            headers: {"x-apikey" : api_key},
            type: type,
            url: url,
            data: values,
            success: function (msg) {
                success(msg);
            }, error: function () {
                fail();
            },
        });
    }

    function returnObjectHTML(object){
        let html = "<div class='flex-container'>";
        for (const [key, value] of Object.entries(object)) {
            if(typeof value === "object"){
                html += "<div class='flex-row'><div class='flex-item'>" + key + "</div><div class='flex-item'>" + returnObjectHTML(value) + "</div></div>";
            }else{
                html += "<div class='flex-row'><div class='flex-item'>" + key + "</div><div class='flex-item'>" + value + "</div></div>";
            }
        }
        html += "</div>";
        return html;
    }

</script>
</body>
</html>