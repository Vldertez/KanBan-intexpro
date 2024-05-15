<?php
include('nav.php');
?>
<link rel="stylesheet" type="text/css" href="assets/crm.css?<?php echo time(); ?>">

<div class="wrapper">
    <div class="nav_menu">
        <div class="top_content">
            <div class="name">
                Г
            </div>

            <div class="name_text">
                <p class="table_name">График</p>
                <p class="table_description">Ежедневные задания</p>
            </div>
        </div>

        <div class="line_Navmenu"></div>

        <div class="bottom_content">
            <div class="addTasks">
                <p class="addTitle">Создать категорию</p>
                <button class="add"><img src="/assets/img/avatars/add.svg" alt="ico"></button>
            </div>
            <ul class="navigation_tasks">
                <li><img src="/assets/img/avatars/ico_crm1.svg" alt="ico"><a href="#">Планирование задач</a></li>
                <li><img src="/assets/img/avatars/ico_crm2.svg" alt="ico"><a href="#">Ежедневные задания</a></li>
                <li><img src="/assets/img/avatars/ico_crm3.svg" alt="ico"><a href="#">Вдохновение для дизайна</a></li>
                <li><img src="/assets/img/avatars/ico_crm4.svg" alt="ico"><a href="#">Продукт</a></li>
                <li><img src="/assets/img/avatars/ico_crm5.svg" alt="ico"><a href="#">Дополнительные задачи</a></li>
            </ul>
        </div>
    </div>

    <div class="tasks_content">
        <div class="top_elements">
            <h1 class="content_title">Ход продукта</h1>
            <ul>
                <li><a href="">Обзор</a></li>
                <li><a href="">Доска</a></li>
                <li><a href="">График</a></li>
                <li><a href="">Деятельность</a></li>
                <li><a href="">Файлы</a></li>
            </ul>
        </div>

        <div class="bottom_elements">        
            <div class="tasks_menu">
                <div class="search-menu">
                <i class="fa fa-search fa-lg"></i><input class="search-butt" type="text" placeholder="Найти...">
                </div>
                <div class="addBoard"><img src="/assets/img/avatars/addWhite.svg" alt="add"><a href="#">Новая доска</a></div>               
                <div class="addFilter"><img src="/assets/img/avatars/Filter_crm.svg" alt="filter"><a href="#">Добавить фильтр</a></div>                
                <div class="сhangeMonth"><img src="/assets/img/avatars/arrow-left_crm.svg" alt="ico"><a href="#">месяц, 00</a><img src="/assets/img/avatars/arrow-right_crm.svg" alt="ico"></div>

            </div>
        </div>
        <div class="tasks_kanban">
            <!-- <div class="kanban_status">
                <div class="status_name">Задачи</div>
                <section>
                    <div class="canban_task">
                        <p class="task_type">Проектирование</p>
                        <h2 class="task_title">Mockups</h2>
                        <p class="task_des">Что-то нужно сделать такое, чтоб вообще взрыв мозга произошел, на решение задачи 1 секунда.</p>
                        <div class="task_avatar">
                            <div>
                                <img src="/assets/img/avatars/image.png" alt="">
                            </div>
                            <span>Легко</span>
                        </div>
                        <div class="task_footer">
                            <div>
                                <img src="/assets/img/沟通 1.svg" alt=""> <span>12</span>
                            </div>
                            <button>Принять</button>
                        </div>
                    </div>
                </section>
                <button class="status_button">+ Добавить карту</button>
            </div>
            <div class="kanban_status">
                <div class="status_name">Задачи</div>
                <section>

                </section>
                <button class="status_button">+ Добавить карту</button>
            </div> -->
        </div>
    </div>



    <script charset="utf-8" type="text/javascript" src="assets/date.js?<?php echo time(); ?>"></script>
    <script charset="utf-8" type="text/javascript" src="assets/js.js?<?php echo time(); ?>"></script>
    <script charset="utf-8" type="text/javascript" src="assets/crm.js?"></script>