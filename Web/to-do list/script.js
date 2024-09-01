document.addEventListener("DOMContentLoaded", () => {
	const todoList = document.querySelector('.todo_list');
	
	const taskForm = todoList.querySelector('.task_form');
	const form = todoList.querySelector('form');
	
	const taskList = todoList.querySelector('.task_list');
	const example = document.getElementById("example").firstElementChild
	
	const actions = {
		EDIT: 0,
		CREATE: 1
	}
	let formAction;
	let editItem;

	function edit(item){
		taskForm.classList.add('shown');
		const priority = item.querySelector('.priority');
		const description = item.querySelector('.description');
		form.reset();
		form.description.value = description.textContent;
		form.priority.checked = !priority.style.opacity	;
		
		formAction = actions.EDIT;
		editItem = item;
	}

	function createItem(description, priority){
		const new_item = example.cloneNode(true);
		new_item.querySelector('.done').checked = false;
		new_item.querySelector('.description').textContent = description;
		new_item.querySelector('.priority').style.opacity = priority ? '' : '0';
		taskList.append(new_item);
	}

	form.addEventListener('submit', e => {
		e.preventDefault();
		if (formAction === actions.CREATE){
			createItem(form.description.value, form.priority.checked)
			form.reset();
		}else if (formAction === actions.EDIT){
			editItem.querySelector('.description').textContent = form.description.value;
			editItem.querySelector('.priority').style.opacity = form.priority.checked ? '' : '0';
		}
	});
	
	taskList.addEventListener('click', function(e) {
		const cl_name = e.target.className
		const item = e.target.parentElement;
		if  (cl_name === "delete"){
			item.remove()
			if (item===editItem)taskForm.classList.remove('shown');
		}else if (cl_name === "edit"){
			edit(item)
		}	
	});

	const addButton = todoList.querySelector('.add_task');
	addButton.addEventListener('click', e => {
		taskForm.classList.add('shown');
		formAction = actions.CREATE
		form.reset();
	});
	
	const closeButton = taskForm.querySelector('.close');
	closeButton.addEventListener('click', e => {
		taskForm.classList.remove('shown');
	});


	createItem("Задача 3",false)
	createItem("Задача 4",true)

});