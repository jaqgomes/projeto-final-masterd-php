function welcomeMsg() {
  setTimeout(() => {
    alert("Sejam Bem-Vindos ao meu Website!");
  }, 5000);
}

function carregaRSS() {
  var url =
    "https://pt.euronews.com/rss?level=program&amp;name=noticias-europeias";
  $.ajax({
    url: "https://api.rss2json.com/v1/api.json?rss_url=" + url,
    type: "GET",

    success: function (data) {
      objeto_json = eval(data);

      var frase = "";
      for (i = 0; i < objeto_json.items.length; i++) {
        frase +=
          "<a href='" +
          objeto_json.items[i].link +
          "' class='list-group-item list-group-item-action py-3 lh-tight'>";
        frase += "<b>Título:</b> " + objeto_json.items[i].title + "<br/>";
        frase +=
          "<b>Descrição:</b> " + objeto_json.items[i].description + "<br/>";
        frase += "</a>";
      }
      $("#caixa").html(frase);
    },
    error: function (xhr, status) {
      alert("Ocorreu um erro.");
    },
  });
}

async function carregarMapa() {
  const { Map, InfoWindow, Event } = await google.maps.importLibrary("maps");
  const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
  const myLocation = { lat: 38.711987, lng: -9.311931 };

  var options = {
    zoom: 12,
    center: myLocation,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    mapId: "DEMO_MAP_ID",
  };

  var myMap = new Map(document.getElementById("mapa"), options);

  const marker = new AdvancedMarkerElement({
    position: myLocation,
    map: myMap,
  });

  var caixa = new InfoWindow({
    content: "Empresa: <b>Minha Empresa</b> <br/> Visite-nos!",
  });

  google.maps.event.addListener(marker, "click", function () {
    caixa.open(myMap, marker);
  });
}

function onLoad() {
  welcomeMsg();
  carregaRSS();
}

function submitBudget() {
  validateBudget();
}

function validateBudget() {
  var form = document.getElementById("formBudget");

  var name = document.getElementById("nameBg");
  var nameError = document.getElementById("msg-nameBg");

  var surname = document.getElementById("surnameBg");
  var surnameError = document.getElementById("msg-surnameBg");

  var cellPhone = document.getElementById("cellPhoneBg");
  var cellPhoneError = document.getElementById("msg-cellPhoneBg");

  var email = document.getElementById("emailBg");
  var emailError = document.getElementById("msg-emailBg");
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  name.addEventListener(
    "input",
    function (event) {
      // Cada vez que o usuário digita algo, verificamos se o
      // campo de email é válido.

      if (name.validity.valid) {
        // Caso haja uma mensagem de erro visível, se o campo
        // é válido, removemos a mensagem de erro.
        nameError.innerHTML = "";
        nameError.className = "error";
      }
    },
    false
  );

  surname.addEventListener(
    "input",
    function (event) {
      // Cada vez que o usuário digita algo, verificamos se o
      // campo de email é válido.

      if (surname.validity.valid) {
        surnameError.innerHTML = "";
        surnameError.className = "error";
      }
    },
    false
  );

  cellPhone.addEventListener(
    "input",
    function (event) {
      // Cada vez que o usuário digita algo, verificamos se o
      // campo de email é válido.

      if (cellPhone.validity.valid) {
        // Caso haja uma mensagem de erro visível, se o campo
        // é válido, removemos a mensagem de erro.
        cellPhoneError.innerHTML = "";
        cellPhoneError.className = "error";
      }
    },
    false
  );

  email.addEventListener(
    "input",
    function (event) {
      // Cada vez que o usuário digita algo, verificamos se o
      // campo de email é válido.

      if (cellPhone.validity.valid) {
        // Caso haja uma mensagem de erro visível, se o campo
        // é válido, removemos a mensagem de erro.
        emailError.innerHTML = "";
        emailError.className = "error";
      }
    },
    false
  );

  form.addEventListener(
    "submit",
    function (event) {
      // Cada vez que o usuário tenta enviar os dados, verificamos
      // se o campo de email for válido.

      if (name.value.length < 3) {
        nameError.innerHTML = "* Tem que ter mais que 3 letras.";
        nameError.className = "error active";

        event.preventDefault();
      }

      if (!name.validity.valid) {
        nameError.innerHTML = "* É obrigatório informar nome de usuário.";
        nameError.className = "error active";

        event.preventDefault();
      }

      if (surname.value.length < 3) {
        surnameError.innerHTML = "* Tem que ter mais que 3 letras.";
        surnameError.className = "error active";

        event.preventDefault();
      }

      if (!surname.validity.valid) {
        surnameError.innerHTML =
          "* O apelido do usuário precisa ter entre 2 a 16 caracteres.";
        surnameError.className = "error active";

        event.preventDefault();
      }

      if (cellPhone.value.length != 9) {
        cellPhoneError.innerHTML = "* Tem que possuir 9 números.";
        cellPhoneError.className = "error active";

        event.preventDefault();
      }

      if (isNaN(cellPhone.value)) {
        cellPhoneError.innerHTML = "* O número inserido não está correto.";
        cellPhoneError.className = "error active";

        event.preventDefault();
      }

      if (!cellPhone.value.startsWith(9)) {
        cellPhoneError.innerHTML = "* Telemóvel não começa com 9.";
        cellPhoneError.className = "error active";

        event.preventDefault();
      }

      if (!cellPhone.validity.valid) {
        cellPhoneError.innerHTML =
          "* O número do usuário precisa ter 9 números.";
        cellPhoneError.className = "error active";

        event.preventDefault();
      }

      if (!email.validity.valid) {
        emailError.innerHTML = "* Insira um email válido.";
        emailError.className = "error active";

        event.preventDefault();
      }
    },
    false
  );
}

function calculateBudget() {
  var valorBase = document.getElementById("pageType");

  var prazo = document.getElementById("periodBg");

  var quemSomos = document.getElementById("whoCheck");
  var ondeEstamos = document.getElementById("whereCheck");
  var galeriaFotos = document.getElementById("photoGallery");
  var eCommerce = document.getElementById("eCommerce");
  var gestaoInterna = document.getElementById("internalManagement");
  var noticia = document.getElementById("news");
  var redeSocial = document.getElementById("socialMedia");

  var valorFinal = parseInt(valorBase.value);

  if (quemSomos.checked) {
    valorFinal = valorFinal + 400;
  }

  if (ondeEstamos.checked) {
    valorFinal = valorFinal + 400;
  }

  if (galeriaFotos.checked) {
    valorFinal = valorFinal + 400;
  }

  if (eCommerce.checked) {
    valorFinal = valorFinal + 400;
  }

  if (gestaoInterna.checked) {
    valorFinal = valorFinal + 400;
  }

  if (noticia.checked) {
    valorFinal = valorFinal + 400;
  }

  if (redeSocial.checked) {
    valorFinal = valorFinal + 400;
  }

  if (prazo.value) {
    var desconto = 5 * prazo.value;

    if (desconto > 20) {
      desconto = 20;
    }

    valorFinal = valorFinal - (desconto / 100) * valorFinal;
  }

  document.getElementById("estimatedBudget").value = valorFinal ? valorFinal : 0;
}

function validateContact() {
  var form = document.getElementById("formContact");

  var name = document.getElementById("nameContact");
  var nameError = document.getElementById("msg-nameContact");

  var surname = document.getElementById("surnameContact");
  var surnameError = document.getElementById("msg-surnameContact");

  var cellPhone = document.getElementById("cellPhoneContact");
  var cellPhoneError = document.getElementById("msg-cellPhoneContact");

  var email = document.getElementById("emailContact");
  var emailError = document.getElementById("msg-emailContact");
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  var meeting = document.getElementById("meetingContact");
  var meetingError = document.getElementById("msg-meetingContact");

  var subjectMeeting = document.getElementById("meetingContact");
  var subjectMeetingError = document.getElementById(
    "msg-subjectMeetingContact"
  );

  nameContact.addEventListener(
    "input",

    function (event) {
      if (name.vality.valid) {
        nameError.innerHTML = "";
        nameError.className = "error";
      }
    },
    false
  );

  surname.addEventListener(
    "input",

    function (event) {
      if (name.value.valid) {
        surnameError.innerHTML = "";
        surnameError.classSurname = "error";
      }
    },
    false
  );

  email.addEventListener(
    "input",
    function (event) {
      if (email.vality.valid) {
        emailError.innerHTML = "";
        emailError.className = "";
      }
    },
    false
  );

  form.addEventListener("submit", function (event) {
    if (name.value.length < 3) {
      nameError.innerHTML = "* Tem que ter mais de 3 letras.";
      nameError.className = "error active";

      event.preventDefault();
    }

    if (!name.validity.valid) {
      nameError.innerHTML = "É obrigatório informar nome do usuário.";
      nameError.className = "error active";

      event.preventDefault();
    }

    if (surname.value.length < 3) {
      surnameError.innerHTML = "* Tem que ter mais de 3 letras.";
      surnameError.className = "error active";

      event.preventDefault();
    }

    if (!surname.validity.valid) {
      surnameError.innerHTML =
        "*O apelido do usuário precisa ter entre 2 a 16 caracteres.";
      surnameError.className = "error active";

      event.preventDefault();
    }

    if (cellPhone.value.length != 9) {
      cellPhoneError.innerHTML = "* Tem que possuir 9 números.";
      cellPhoneError.className = "error active";

      event.preventDefault();
    }

    if (isNaN(cellPhone.value)) {
      cellPhoneError.innerHTML = "* O número inserido não está correto";
      cellPhoneError.className = "error active";

      event.preventDefault();
    }

    if (!cellPhone.value.startsWith(9)) {
      cellPhoneError.innerHTML = "* Telemóvel não começa com 9";
      cellPhoneError.className = "error active";

      event.preventDefault();
    }

    if (!email.validity.valid) {
      emailError.innerHTML = "* Insira um email válido.";
      emailError.className = "error active";

      event.preventDefault();
    }
  });
}
