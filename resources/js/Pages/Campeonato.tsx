import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { PageProps } from '@/types';
import Select2 from '@/Components/Select';
import PrimaryButton from '@/Components/PrimaryButton';
import React, { useState } from 'react';
import Swal from 'sweetalert2'

export default function Campeonato({ auth }: PageProps) {

    
    const [idSelecionados, setIdSelecionados] = useState<string[]>([]);

    const handleSelecionadosChange = (novosSelecionados: string[]) => {
        setIdSelecionados(novosSelecionados);
    };

    const handleRealizarCampeonato = async () => {
        try {
            Swal.fire({
                title: 'Que os jogos comecem!',
                html: '<img src="https://media1.tenor.com/m/kXdU71jKYuYAAAAd/ameno-dorime-dorime.gif" width="300"  style="margin: 0 auto" alt="GIF">',
                icon: 'info',
                showConfirmButton: false
            })
            const csrfTokenMeta = document.head.querySelector('meta[name="csrf-token"]');

            if (!csrfTokenMeta) {
                console.error('Meta tag CSRF não encontrada.');
                return;
            }

            const csrfToken = csrfTokenMeta.getAttribute('content');
            const headers = {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken || '', // Se csrfToken for nulo, use uma string vazia
            };

            
            const response = await fetch('http://localhost:8989/realizarcampeonato', {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({
                    timesSelecionados: idSelecionados,
                }),
            });
            if(!response.ok){
                const errorResponse = await response.json();
                const errorMessage = errorResponse.error;
                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'Ok!'
                })
            }else{

                const successResponse = await response.json();
             
                let message = "Os vencedores são:\n";

                // Iterando sobre as chaves e valores do objeto successResponse
                Object.entries(successResponse.sucesso).forEach(([posicao, nomeTime]) => {
                    message += ' ' + `${posicao.replace("_", " ")}:  ${nomeTime}`;
                });
                Swal.fire({
                    title: 'Sucesso!',
                    text: message,
                    icon: 'success',
                    confirmButtonText: 'Ok!'
                })
            }
        } catch (error) {
           
        }
    };


    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Campeonato</h2>}
        >
            <Head title="Campeonato" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg py-12 pb-64">
                        <div className="ms-3 pb-1 text-gray-900">Selecione os times participantes e clique em Realizar Campeonato</div>
                        <div className="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <div className='pb-12'>
                                <Select2 idSelecionados={idSelecionados} onSelecionadosChange={handleSelecionadosChange} />
                            </div>
                           
                            <PrimaryButton id='realizar_campeonato' onClick={handleRealizarCampeonato}>
                                Realizar Campeonato
                            </PrimaryButton>
                        </div>
                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
