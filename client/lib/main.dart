// ignore_for_file: prefer_const_constructors, prefer_const_literals_to_create_immutables

import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

void main() async {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) { 
    return MaterialApp(
      title: 'Flutter Demo',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
        useMaterial3: true,
      ),
      home: MyHomePage(),
    );
  }
}

class MyHomePage extends StatefulWidget {
  @override
  State<MyHomePage> createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {
  String? _planoSelecionado;
  String? _categoriaSelecionada;
  String? _especialidadeSelecionada;
  Map<String, dynamic> dados = {};
  List<dynamic> especialidadesFiltradas = [];
  String? _valorConsulta;
                            
  Future<void> fetchDados() async {
    final response = await http.get(Uri.parse('http://192.168.0.10:8080/public'));

    if (response.statusCode == 200) {
      print('Conexão bem-sucedida');
      setState(() {
        dados = json.decode(response.body);
      });
    } else {
        throw Exception('Falha na conexão: ${response.statusCode}');
    }
  }

  Future<void> getValorConsulta() async {
    final response = await http.post(
      Uri.parse('http://192.168.0.10:8080/public'),  
      body: {
        'nm_especialidade': _especialidadeSelecionada,
        'id_categoria': _categoriaSelecionada,
        'id_plano_saude': _planoSelecionado,
      },
    );

    if (response.statusCode == 200) {
      final responseData = json.decode(response.body);
      setState(() {
        _valorConsulta = responseData['valorConsulta'].toString();
      });
    } else {
      throw Exception('Falha ao consultar valor da consulta');
    }
  }

  @override
  void initState() {
    super.initState();
    fetchDados(); 
  }

  @override
  Widget build(BuildContext context){
    return Scaffold(
      appBar: AppBar(
        title: Text('Simular Valor da Consulta'),
      ),
      
      body: Center(
        child: Container(
          padding: EdgeInsets.all(10.0),
          alignment: Alignment.center,
          child: Form(
            child: dados.isEmpty 
              ? CircularProgressIndicator()
              : ListView(
              children: <Widget>[
                if (dados.containsKey('planoSaude') && dados['planoSaude'].isNotEmpty)
                  DropdownButtonFormField<String>(
                    decoration: InputDecoration(
                      labelText: 'Selecionar Plano de Saúde',
                    ),
                    items: dados['planoSaude'].map<DropdownMenuItem<String>>((planoSaude) {
                      return DropdownMenuItem(
                        value: planoSaude['id_plano_saude'].toString(),
                        child: Text(planoSaude['nm_plano']),
                      );
                    }).toList(),
                    onChanged: (String? newValue) { 
                      setState(() {
                        _planoSelecionado = newValue;
                        especialidadesFiltradas = dados['especialidade']
                                .where((especialidade) => especialidade['fk_plano_saude'].toString() == _planoSelecionado)
                                .toList();
                      });
                    },
                  ),

                  if (dados.containsKey('planoCategoria') && dados['planoCategoria'].isNotEmpty)
                  DropdownButtonFormField<String>(
                    decoration: InputDecoration(
                      labelText: 'Selecionar Categoria',
                    ),
                    items: dados['planoCategoria'].map<DropdownMenuItem<String>>((especialidade) {
                      return DropdownMenuItem(
                        value: especialidade['id_categoria'].toString(),
                        child: Text(especialidade['id_categoria'].toString())
                      );
                    }).toList(),                     
                    onChanged: (String? newValue){
                      setState(() {
                         _categoriaSelecionada = newValue;
                      });
                    }
                  ),

                if (_planoSelecionado != null && dados.containsKey('especialidade') && dados['especialidade'].isNotEmpty)
                  DropdownButtonFormField(
                    decoration: InputDecoration(
                      labelText: 'Selecionar Especialidade'
                    ),
                    items: especialidadesFiltradas.map<DropdownMenuItem<String>>((especialidade) {
                      return DropdownMenuItem(
                        value: especialidade['nm_especialidade'].toString(),
                        child: Text(especialidade['nm_especialidade'])
                      );
                    }).toList(), 
                    onChanged: (String? newValue){
                      setState(() {
                        _especialidadeSelecionada = newValue;
                      });
                    }
                  ),

                  Row(
                    mainAxisAlignment: MainAxisAlignment.end,
                    children: <Widget>[
                      TextButton(
                        child: Text('Consultar'),
                        onPressed: () {
                          getValorConsulta();
                          setState(() {   
                            _planoSelecionado = null;
                            _especialidadeSelecionada = null;
                            especialidadesFiltradas = [];
                          });
                        } 
                      )
                    ]
                  ),
                if (_valorConsulta != null)
                Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Text(
                    'Valor da Contribuição: $_valorConsulta', 
                    style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                  ),
                ),

              ],
            ),
          ),
        ),
      ),
    );
  }
}

