import React, { useState, useEffect } from 'react';
import Select from 'react-select';
import Swal from 'sweetalert2'

interface Opcao {
    id: string;
    name: string;
}
interface Selecionados {
    idSelecionados: string[];
    onSelecionadosChange: (novosSelecionados: string[]) => void;
}



const Select2: React.FC<Selecionados> = ({ idSelecionados, onSelecionadosChange }) => {
    const [opcoes, setOpcoes] = useState<Opcao[]>([]);

    useEffect(() => {
        Swal.fire({
            title: 'Pera ae que os times estão carregando, Docker pode ser duro as vezes',
            html: '<img src="https://media1.tenor.com/m/ZOBVifgI9eEAAAAC/kermit-water.gif" width="300"  style="margin: 0 auto" alt="GIF">',
            icon: 'info',
            showConfirmButton: false
        })
        fetch('http://localhost:8989/participantes')
            
            .then(response => response.json())
            .then(data => {
                setOpcoes(data);
                Swal.close()
            })
            .catch(error => {
                console.error('Erro na requisição:', error);
                Swal.fire({
                    title: 'Sem Times cadastrados',
                    icon: 'info',
                    showConfirmButton: false
                })
            });
    }, []);

    return (
        <div className="relative">
            <Select
                isMulti
                name="teams"
                options={opcoes.map(opcao => ({
                    value: opcao.id,
                    label: opcao.name
                }))}
                className="basic-multi-select"
                classNamePrefix="select"
                onChange={selectedOptions => {
                    const selectedValues = selectedOptions.map(option => option.value);
                    onSelecionadosChange(selectedValues); // Chamando a função de callback com os novos valores selecionados
                }}

            />
        </div>
    );
}


export default Select2;