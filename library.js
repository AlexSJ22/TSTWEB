//funcion para validar el XML con el XSD
function validarXMLConXSD(xml, xsd) {

    xmllint.validation = true;

    var validationResult = xmllint.validateXML({
        xml: new XMLSerializer().serializeToString(xml),
        schema: new XMLSerializer().serializeToString(xsd)
    });

    if (validationResult.errors) {
        console.error("Error de validación del XML");
        console.error(validationResult.errors);
    }

    return !validationResult.errors;
}

// Función para transformar XML con XSL
function transformarXMLConXSL(xml, xsl) {
    var xsltProcessor = new XSLTProcessor();
    xsltProcessor.importStylesheet(xsl);

    var resultDocument = xsltProcessor.transformToDocument(xml);

    return new XMLSerializer().serializeToString(resultDocument);
}


function cargaPresentacion(){
    $("main").load("presentacion.html");

}

function cargaTabla(){
    $("main").load("tabla.html");
    cargaXML();
}

function cargaFormulario(){
    $("main").load("formulario.html");

}

function reloadTabla(){
    $.ajax({
        type: "POST",
        url: "http://localhost:8000/server.php",
        data: { code: $("#opt").val() },
        dataType: "xml",
        success: function (xml) {
            console.log("XML cargado correctamente.");
            cargarXSD(xml);
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar el XML:", error);
        }
    });
}

function cargaXML() {
    $.ajax({
        type: "GET",
        url: "http://localhost:8000/server.php",
        dataType: "xml",
        success: function (xml) {
            console.log("XML cargado correctamente.");
            cargarXSD( xml);
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar el XML:", error);
        }
    });
}

// Función para cargar XSD. En caso de éxito, valida
function cargarXSD( xml) {
    $.ajax({
        type: "GET",
        url: "estudiantes.xsd",
        dataType: "xml",
        success: function (xsd) {
            console.log("XSD cargado correctamente.");
            if (validarXMLConXSD(xml, xsd) == true) {
                console.log("XML correctamente validado.");
                cargarXSL( xml);
            } else {
                console.error("El XML no es válido según el XSD.");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar el XSD:", error);
        }
    });
}



// Función para cargar XSL. En caso de éxito, transofrma
function cargarXSL( xml) {
    $.ajax({
        type: "GET",
        url: "estudiantes.xsl",
        dataType: "xml",
        success: function (xsl) {
            console.log("XSL cargado correctamente.");
            var resultado = transformarXMLConXSL(xml, xsl);
            console.log("Resultado de la transformación:", resultado);
            $("#tablearea").html(resultado);
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar el XSL:", error);
        }
    });
}

