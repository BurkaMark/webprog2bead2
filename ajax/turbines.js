function counties()
{
    $.post("turbines.php",
        {"op" : "county"},
        function(data)
        {
            $("<option>").val("0").text("Válasszon...").appendTo("#countySelect");
            var list = data.list;
            for(i=0; i<list.length; i++)
                $("<option>").val(list[i].id).text(list[i].nev).appendTo("#countySelect");
        },
        "json"                                                    
    );
};

function cities()
{
    $("#citySelect").html("");
    $("#turbineSelect").html("");
    $(".data").html("");
    var countyid = $("#countySelect").val();
    if (countyid != 0)
    {
        $.post("turbines.php",
            {"op" : "city", "id" : countyid},
            function(data)
            {
                $("#citySelect").html('<option value="0">Válasszon ...</option>');
                var list = data.list;
                for(i=0; i<list.length; i++)
                    $("#citySelect").append('<option value="'+list[i].id+'">'+list[i].nev+'</option>');
            },
            "json"                                                    
        );
    }
}

function turbines()
{
    $("#turbineSelect").html("");
    $(".data").html("");
    var cityid = $("#citySelect").val();
    if (cityid != 0)
    {
        $.post("turbines.php",
            {"op" : "turbine", "id" : cityid},
            function(data)
            {
                $("#turbineSelect").html('<option value="0">Válasszon ...</option>');
                var list = data.list;
                for(i=0; i<list.length; i++)
                    $("#turbineSelect").append('<option value="'+list[i].id+'">'+list[i].id+'</option>');
            },
            "json"                                                    
        );
    }
}

function turbine()
{
    $(".data").html("");
    var turbineid = $("#turbineSelect").val();
    if (turbineid != 0)
    {
        $.post("turbines.php",
            {"op" : "info", "id" : turbineid},
            function(data)
            {
                $("#quantity").text(data.quantity);
                $("#performance").text(data.performance);
                $("#initialYear").text(data.initialYear);
                $("#region").text(data.region);
            },
            "json"
        );
    }
}

$(document).ready(function()
{
    counties();
   
    $("#countySelect").change(cities);
    $("#citySelect").change(turbines);
    $("#turbineSelect").change(turbine);
    
    $(".data").hover(function()
    {
        $(this).css({"color" : "white", "background-color" : "black"});
    },
    function()
    {
        $(this).css({"color" : "black", "background-color" : "white"});
    });
});