<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Favorito;

class Favoritos extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $titulo, $tema, $url;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.favoritos.view', [
            'favoritos' => Favorito::latest()
						->orWhere('titulo', 'LIKE', $keyWord)
						->orWhere('tema', 'LIKE', $keyWord)
						->orWhere('url', 'LIKE', $keyWord)
						->paginate(10),
        ]);
    }
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }
	
    private function resetInput()
    {		
		$this->titulo = null;
		$this->tema = null;
		$this->url = null;
    }

    public function store()
    {
        $this->validate([
		'titulo' => 'required',
		'tema' => 'required',
		'url' => 'required',
        ]);

        Favorito::create([ 
			'titulo' => $this-> titulo,
			'tema' => $this-> tema,
			'url' => $this-> url
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Favorito Successfully created.');
    }

    public function edit($id)
    {
        $record = Favorito::findOrFail($id);

        $this->selected_id = $id; 
		$this->titulo = $record-> titulo;
		$this->tema = $record-> tema;
		$this->url = $record-> url;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'titulo' => 'required',
		'tema' => 'required',
		'url' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Favorito::find($this->selected_id);
            $record->update([ 
			'titulo' => $this-> titulo,
			'tema' => $this-> tema,
			'url' => $this-> url
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Favorito Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Favorito::where('id', $id);
            $record->delete();
        }
    }
}
