<?php

class Language extends Api {
  private $dba = NULL;

  public function get($elements) {
    if (isset($elements[0]) && !empty($elements[0])) {
      $this->getOne($elements[0]);
    } else {
      $this->getAll();
    }
  }

  public function post($elements) {
    if (!$this->checkAuthorization()) {
      $this->forbidden();
      exit();
    }
    $raw = file_get_contents('php://input');
    if (!empty($raw)) {
      $data = $this->dba()->parse($raw);
      $id = $this->dba()->create($data);
      if ($id) {
        $this->ok(
          sprintf('Created new language with ID %d.', $id),
          'success'
        );
      } else {
        $this->badRequest("Could not create a new record; database error.");
      }
    } else {
      $this->badRequest("You provided no data to insert.");
    }
  }

  public function put($elements) {
    if (!$this->checkAuthorization()) {
      $this->forbidden();
      return;
    }
    if (isset($elements[0])) {
      $id = $elements[0];
      $raw = file_get_contents('php://input');
      if (!empty($raw)) {
        $data = $this->dba()->parse($raw);
        $success = $this->dba()->update($id, $data);
        if ($success) {
          $this->ok(
            'Language successfully modified.',
            'success'
          );
	  return;
        }
      }
    }
    $this->badRequest();
  }

  public function delete($elements) {
    if (!$this->checkAuthorization()) {
      $this->forbidden();
      return;
    }
    if (isset($elements[0])) {
      $id = $elements[0];
      $success = $this->dba()->delete($id);
      if ($success) {
        $this->ok(
          'Language successfully deleted.',
          'success'
	);
	return;
      }
    }
    $this->badRequest();
  }

  protected function getOne($id) {
    $language = $this->dba()->getById($id);
    if (!empty($language)) {
      $this->ok(
        $this->response()->getRecord($language, 'language')
      );
    } else {
      $this->notFound();
    }
  }

  protected function getAll() {
    if (isset($_GET['search'])) {
      $data = $this->dba()->getBySearch($_GET['search']);
    } else {
      $data = $this->dba()->getAll();
    }
    if (!empty($data)) {
      $this->ok(
        $this->response()->getRecords(
          $data, 'languages', 'language'
        )
      );
    } else {
      $this->notFound();
    }
  }

  public function dba($dba = NULL) {
    if ($dba !== NULL) {
      $this->dba = $dba;
    } elseif ($this->dba === NULL) {
      $this->dba = new LanguageDba($this->requestFormat);
    }
    return $this->dba;
  }
}
