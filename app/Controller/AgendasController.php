<?php
App::uses('AppController', 'Controller');
/**
 * Agendas Controller
 *
 * @property Agenda $Agenda
 * @property PaginatorComponent $Paginator
 */
class AgendasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Agenda->recursive = 0;
		$this->set('agendas', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Agenda->exists($id)) {
			throw new NotFoundException(__('Invalid agenda'));
		}
		$options = array('conditions' => array('Agenda.' . $this->Agenda->primaryKey => $id));
		$this->set('agenda', $this->Agenda->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Agenda->create();
			if ($this->Agenda->save($this->request->data)) {
				$this->Session->setFlash(__('The agenda has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The agenda could not be saved. Please, try again.'));
			}
		}
		$users = $this->Agenda->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Agenda->exists($id)) {
			throw new NotFoundException(__('Invalid agenda'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Agenda->save($this->request->data)) {
				$this->Session->setFlash(__('The agenda has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The agenda could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Agenda.' . $this->Agenda->primaryKey => $id));
			$this->request->data = $this->Agenda->find('first', $options);
		}
		$users = $this->Agenda->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Agenda->id = $id;
		if (!$this->Agenda->exists()) {
			throw new NotFoundException(__('Invalid agenda'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Agenda->delete()) {
			$this->Session->setFlash(__('The agenda has been deleted.'));
		} else {
			$this->Session->setFlash(__('The agenda could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
