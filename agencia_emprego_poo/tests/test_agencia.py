import sqlite3

import pytest

from database.conexao import ConexaoBD
from database.repo_contrato import RepositorioContrato
from database.repo_empresa import RepositorioEmpresa
from database.repo_profissional import RepositorioProfissional
from models.contrato import Contrato
from models.empresa import Empresa
from models.profissional import Profissional


@pytest.fixture
def conexao_memoria():
    con = ConexaoBD(":memory:")
    yield con
    con.close()


def _dados_base():
    profissional = Profissional(
        cpf="12345678900",
        nome="João",
        endereco="Rua A, 100",
        data_nascimento="1990-01-01",
        profissao="Eletricista",
    )
    empresa = Empresa(cnpj="12345678000190", razao_social="Tech Ltda", endereco="Av B, 200")
    return profissional, empresa


def test_calcular_valor_total_horas_validas():
    profissional, empresa = _dados_base()
    contrato = Contrato(profissional=profissional, empresa=empresa, data_inicio="2026-01-01", data_termino="2026-02-01", valor_hora=50)
    assert contrato.calcular_valor_total(10) == 500


def test_contrato_com_valor_hora_invalido_deve_lancar_value_error():
    profissional, empresa = _dados_base()
    with pytest.raises(ValueError):
        Contrato(profissional=profissional, empresa=empresa, data_inicio="2026-01-01", data_termino="2026-02-01", valor_hora=0)
    with pytest.raises(ValueError):
        Contrato(profissional=profissional, empresa=empresa, data_inicio="2026-01-01", data_termino="2026-02-01", valor_hora=-10)


def test_contrato_sem_profissional_deve_lancar_excecao():
    _, empresa = _dados_base()
    with pytest.raises(ValueError):
        Contrato(profissional=None, empresa=empresa, data_inicio="2026-01-01", data_termino="2026-02-01", valor_hora=20)


def test_contrato_sem_empresa_deve_lancar_excecao():
    profissional, _ = _dados_base()
    with pytest.raises(ValueError):
        Contrato(profissional=profissional, empresa=None, data_inicio="2026-01-01", data_termino="2026-02-01", valor_hora=20)


def test_str_polimorfico_profissional_e_empresa():
    profissional, empresa = _dados_base()
    assert "João" in str(profissional)
    assert "Tech Ltda" in str(empresa)


def test_persistencia_inserir_recuperar_profissional(conexao_memoria):
    repo = RepositorioProfissional(conexao_memoria)
    profissional, _ = _dados_base()

    repo.inserir(profissional)
    encontrado = repo.buscar_por_cpf(profissional.cpf)

    assert encontrado is not None
    assert encontrado.nome == "João"


def test_persistencia_inserir_recuperar_empresa(conexao_memoria):
    repo = RepositorioEmpresa(conexao_memoria)
    _, empresa = _dados_base()

    repo.inserir(empresa)
    encontrada = repo.buscar_por_cnpj(empresa.cnpj)

    assert encontrada is not None
    assert encontrada.razao_social == "Tech Ltda"


def test_persistencia_registrar_contrato_e_listar(conexao_memoria):
    repo_prof = RepositorioProfissional(conexao_memoria)
    repo_emp = RepositorioEmpresa(conexao_memoria)
    repo_cont = RepositorioContrato(conexao_memoria)
    profissional, empresa = _dados_base()

    repo_prof.inserir(profissional)
    repo_emp.inserir(empresa)

    contrato = Contrato(
        profissional=profissional,
        empresa=empresa,
        data_inicio="2026-01-01",
        data_termino="2026-12-31",
        valor_hora=45,
    )

    numero = repo_cont.inserir(contrato)
    contratos = repo_cont.listar_todos()

    assert numero > 0
    assert len(contratos) == 1
    assert contratos[0].profissional.cpf == profissional.cpf


def test_exclusao_profissional_com_contrato_lanca_excecao(conexao_memoria):
    repo_prof = RepositorioProfissional(conexao_memoria)
    repo_emp = RepositorioEmpresa(conexao_memoria)
    repo_cont = RepositorioContrato(conexao_memoria)
    profissional, empresa = _dados_base()

    repo_prof.inserir(profissional)
    repo_emp.inserir(empresa)
    repo_cont.inserir(
        Contrato(
            profissional=profissional,
            empresa=empresa,
            data_inicio="2026-01-01",
            data_termino="2026-12-31",
            valor_hora=60,
        )
    )

    with pytest.raises(sqlite3.IntegrityError):
        repo_prof.remover(profissional.cpf)
