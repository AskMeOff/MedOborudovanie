<link rel="stylesheet" href="css/minsk.css">
<style>
    .contact-block {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin: 15px 0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }
    .contact-block:hover {
        transform: scale(1.02);
    }
    .contact-title {
        font-size: 1.5em;
        margin-bottom: 10px;
        color: #007bff;
        border-bottom: 2px solid #007bff;
        padding-bottom: 5px;
    }
    .contact-info {
        font-size: 1.1em;
        line-height: 1.6;
        margin-top: 10px;
    }
    .contact-info p {
        margin: 5px 0;
    }
    .contact-info a {
        color: #007bff;
        text-decoration: none;
    }
    .contact-info a:hover {
        text-decoration: underline;
    }
    .description-block {
        background-color: #e9ecef;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 20px;
        margin: 15px 0;
        text-align: center;
    }
    .description-title {
        font-size: 1.5em;
        margin-bottom: 10px;
        color: #343a40;
    }
    .description-info {
        font-size: 1.1em;
        margin: 10px 0;
    }
    .video-block {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin: 15px 0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
        text-align: center;
    }
    .video-block:hover {
        transform: scale(1.02);
    }
    .video-title {
        font-size: 1.5em;
        margin-bottom: 10px;
        color: #007bff;
        border-bottom: 2px solid #007bff;
        padding-bottom: 5px;
    }
    .video-info {
        font-size: 1.1em;
        line-height: 1.6;
        margin-top: 10px;
    }
    .video-info p {
        margin: 5px 0;
    }
    .video-thumbnail {
        width: 100%;
        height: auto;
        border-radius: 5px;
        margin-bottom: 10px;
    }
    .video-link {
        color: #007bff;
        text-decoration: none;
        display: inline-block;
        margin-top: 10px;
    }
    .video-link:hover {
        text-decoration: underline;
    }
</style>

<section class="content" style="margin-top: 100px; margin-left: 15px">
    <div class="container-fluid" id="container_fluid" style="overflow: auto; height: 85vh;">
        <div class="row" id="main_row">
            <h1 class="ms-3">Руководство пользователя и видеоинструкции</h1>
            <section class="col-lg-11 connectedSortable ui-sortable" style="display: block;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="description-block">
                            <div class="description-title">Дополнительные ресурсы</div>
                            <div class="description-info">
                                <p>Руководство пользователя:</p>
                                <a href="../../documents/v0802Руководство пользователя АИС ВТМО.docx" class="btn btn-info">Скачать Руководство</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="video-block">
                            <video controls class="video-thumbnail" width="100%">
                                <source src="../../documents/Добавление оборудования.webm" type="video/mp4">
                                Ваш браузер не поддерживает видео.
                            </video>
                            <div class="video-title">Видеоинструкция "Добавление оборудования"</div>
                            <div class="video-info">
                                <p>В данном видео мы подробно расскажем, как войти в свой аккаунт и найти кнопку для добавления оборудования.
                                    Вы познакомитесь с простыми шагами, которые помогут вам быстро и легко выполнить эту задачу.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="video-block">
                            <video controls class="video-thumbnail" width="100%">
                                <source src="../../documents/Добавление оборудования.webm" type="video/mp4">
                                Ваш браузер не поддерживает видео.
                            </video>
                            <div class="video-title">Видеоинструкция 2</div>
                            <div class="video-info">
                                <p>Краткое описание видеоинструкции 2.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="video-block">
                            <video controls class="video-thumbnail" width="100%">
                                <source src="../../documents/Добавление оборудования.webm" type="video/mp4">
                                Ваш браузер не поддерживает видео.
                            </video>
                            <div class="video-title">Видеоинструкция 3</div>
                            <div class="video-info">
                                <p>Краткое описание видеоинструкции 3.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
