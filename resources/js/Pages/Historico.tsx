import React, { useState, useEffect } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { PageProps } from '@/types';
import Swal from 'sweetalert2'


export default function Historico({ auth }: PageProps) {

    interface Campeonato {
        id: number;
        primeiro_colocado: { name: string };
        segundo_colocado: { name: string };
        terceiro_colocado: { name: string };
        quarto_colocado: { name: string };
    }

    const [resultados, setResultados] = useState<Campeonato[]>([]);

    useEffect(() => {
        Swal.fire({
            title: 'Aguarde novamente',
            html: '<img src="https://media1.tenor.com/m/ZOBVifgI9eEAAAAC/kermit-water.gif" width="300"  style="margin: 0 auto" alt="GIF">',
            icon: 'info',
            showConfirmButton: false
        })
        const endpoint = 'http://localhost:8989/gethistorico';
       
        // Fazendo a requisição usando fetch
        fetch(endpoint)
            .then(response => response.json())
            .then(data => {
                if(data.length){
                    setResultados(data)
                }else{
                    Swal.fire({
                        title: 'Sem Campeonatos registrados',
                        icon: 'info',
                        confirmButtonText: 'Ok!'
                    })
                }
            }
               
            )
            .catch(error => {
                console.error('Erro na requisição:', error);
                Swal.fire({
                    title: 'Sem Campeonatos registrados',
                    icon: 'info',
                    showConfirmButton: false
                })
            });
            console.log(resultados);
    }, []); // Executa a requisição ape


    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Campeonato</h2>}
        >
            <Head title="Campeonato" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg py-12 pb-64">
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 p-3">
                            {resultados.map((resultado, index) => (
                                <div key={index} className="w-full">
                                    <div className="bg-gray-100 shadow-md rounded-md p-4">
                                        <h1 className="text-lg font-semibold mb-2">Campeonato de número: {resultado.id}</h1>
                                        <h3 className="text-lg font-semibold mb-2">Primeiro: {resultado.primeiro_colocado.name}</h3>
                                        <h3 className="text-lg font-semibold mb-2">Segundo: {resultado.segundo_colocado.name}</h3>
                                        <h3 className="text-lg font-semibold mb-2">Terceiro: {resultado.terceiro_colocado.name}</h3>
                                        <h3 className="text-lg font-semibold mb-2">Quarto: {resultado.quarto_colocado.name}</h3>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
