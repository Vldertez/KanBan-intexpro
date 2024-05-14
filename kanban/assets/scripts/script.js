const statuses = [
    {
        "id": 0,
        "name": "Статус 1",
        "el": {}
    },
    {
        "id": 1,
        "name": "Статус 2",
        "el": {}
    }
];
const tasks = [
    {
        id: 1,
        name: 'Задача 1',
        description: 'Описание 1',
        executor: 'Испольнителть 1',
        provider: 'Поставщик 1',
        dateCreate: '2024.05.04',
        dateStart: '2024.05.05',
        dateEnd: '2024.05.08',
        dateFinish: '2024.05.09',
        el: {},
    },
    {
        id: 2,
        name: 'Задача 2',
        description: 'Описание 2',
        executor: 'Испольнителть 2',
        provider: 'Поставщик 1',
        dateCreate: '2024.05.06',
        dateStart: '2024.05.09',
        dateEnd: '2024.05.13',
        dateFinish: '',
        el: {},
    },
    {
        id: 3,
        name: 'Задача 3',
        description: 'Описание 3',
        executor: 'Испольнителть 1',
        provider: 'Поставщик 2',
        dateCreate: '2024.05.09',
        dateStart: '2024.05.11',
        dateEnd: '2024.05.18',
        dateFinish: '',
        el: {},
    },
];

const history = {
    1: [{
        date: '2024.05.04',
        idStatus: '0',
    },{
        date: '2024.05.09',
        idStatus: '1',
    }],
    2: [{
        date: '2024.05.06',
        idStatus: '0',
    }],
    3: [{
        date: '2024.05.09',
        idStatus: '1',
    }],
}

const buttonCreateStatus = document.querySelector('.createStatus');
buttonCreateStatus.addEventListener('submit', (e) =>{
    e.preventDefault();
    createStatus(statuses, e);
    printStatuses(statuses);
})
const buttonCreateTask = document.querySelector('.createTask');
buttonCreateTask.addEventListener('submit', (e) =>{
    e.preventDefault();
    createTask(tasks,history, e);
    printTasks(statuses, tasks, history);
})

function createStatus(statuses, e) {
    let name = e.srcElement.name.value;
    let id = statuses.length;
    let el = cretateElStatus(id, name);

    object = {id, name, el}
    statuses.push(object);
    printSelect(statuses);
    printTasks(statuses, tasks, history);
}
function cretateElStatus(id, name) {
    let el = document.createElement('div');
    el.classList = 'status';
    el.dataset['id'] = id+1;
    el.innerHTML = `<h2>${name}</h2>`;
    el.innerHTML += `<div class="tasks"></div>`;

    return el;
}
function printStatuses(statuses) {
    let kanban = document.querySelector('.kanban');
    statuses.forEach(status => {
        kanban.append(status.el);
    });
    // 
}
function printSelect(statuses) {
    let select = document.querySelector('.statusSelect');
    select.innerHTML = '';
    statuses.forEach(status => {
        select.innerHTML += `<option value='${status.id}'>${status.name}</option>`
    });
}

function createTask(tasks, history, e) {
    let date = new Date();

    let name = e.srcElement.name.value;
    let id = tasks.length+1;
    let description = e.srcElement.description.value;
    let executor = e.srcElement.executor.value;
    let provider = e.srcElement.provider.value;
    let dateCreate =  date.getFullYear() + '.' + ('0' + (date.getMonth() + 1)).slice(-2) + '.' + ('0' + date.getDate()).slice(-2);
    let dateStart = e.srcElement.dateStart.value;
    let dateEnd = e.srcElement.dateEnd.value;

    let el = createElTasks(id, name, statuses, history);

    object = {
        id, 
        name, 
        description, 
        executor, 
        provider, 
        dateCreate, 
        dateStart, 
        dateEnd, 
        el,
    }
    history[id] = [];
    history[id].push({
        date: dateCreate,
        idStatus: e.srcElement.status.value,
    });
    tasks.push(object);

    printSelect(statuses);
}
function createElTasks(id, name, statuses, history) {
    let el = document.createElement('div');
    el.classList = 'task';
    el.dataset['id'] = id;
    el.innerHTML = `${name}`;
    let select = document.createElement('select');
    el.append(select);

    return el;
}

function printTasks(statuses, tasks, history) {

    tasks.forEach(task => {
        let id = task.id;
        let idStatus = history[id][history[id].length-1].idStatus;
        let status = statuses.find(item => item.id == idStatus);
        console.log(status);
        status.el.querySelector('.tasks').append(task.el);
        


        let select = task.el.querySelector('select');
        console.log(select);
        let html = ``;
        
        statuses.forEach(status => {
            let selected =(status.id == history[task.id][history[task.id].length-1].idStatus)? 'selected': '';
            html += `<option ${selected} value="${status.id}">${status.name}</option>`;
        });
        select.innerHTML = html;
        let date = new Date();
        select.addEventListener('change', (e) => {
            history[id].push({
                date: date.getFullYear() + '.' + ('0' + (date.getMonth() + 1)).slice(-2) + '.' + ('0' + date.getDate()).slice(-2),
                idStatus: e.target.value,
                
            });
            printTasks(statuses, tasks, history)
        });
        console.log(task.el)
        task.el.append(select);
    });


    // tasks.forEach(task => {
       
    // });
}






function index(statuses, tasks, history) {
    statuses.forEach(status => {
        status.el = cretateElStatus(status.id, status.name);
    });
    printSelect(statuses);
    printStatuses(statuses);

    tasks.forEach(task => {
        task.el = createElTasks(task.id, task.name, statuses, history);
    })
    printTasks(statuses, tasks, history);

}
index(statuses, tasks, history);
