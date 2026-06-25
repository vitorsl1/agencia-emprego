# Agência de Emprego Temporário (POO)

## Justificativas

- **SQLite3**: biblioteca nativa do Python, sem servidor externo, ideal para execução local e entrega simples em arquivo único (`agencia.db`).
- **Tkinter**: biblioteca GUI nativa do Python, sem dependências extras e suficiente para telas de cadastro, listagem e histórico.

## Estrutura

```text
agencia_emprego_poo/
├── main.py
├── README.md
├── requirements.txt
├── models/
│   ├── pessoa.py
│   ├── profissional.py
│   ├── empresa.py
│   ├── contrato.py
│   └── agencia.py
├── database/
│   ├── conexao.py
│   ├── repo_profissional.py
│   ├── repo_empresa.py
│   └── repo_contrato.py
├── gui/
│   ├── app.py
│   ├── tela_profissionais.py
│   ├── tela_empresas.py
│   ├── tela_contratos.py
│   └── tela_historico.py
└── tests/
    └── test_agencia.py
```

## Execução

```bash
pip install -r requirements.txt
python main.py
```

## Testes

```bash
pytest tests/
```

## Observações

- Requer Python **3.10+**.
- O banco `agencia.db` é criado automaticamente ao executar `main.py`.
