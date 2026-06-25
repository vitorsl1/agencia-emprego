from database.conexao import ConexaoBD
from database.repo_contrato import RepositorioContrato
from database.repo_empresa import RepositorioEmpresa
from database.repo_profissional import RepositorioProfissional
from models.contrato import Contrato
from models.empresa import Empresa
from models.profissional import Profissional


class AgenciaEmprego:
    def __init__(self, db_path: str = "agencia.db") -> None:
        self.conexao = ConexaoBD(db_path)
        self.repo_profissional = RepositorioProfissional(self.conexao)
        self.repo_empresa = RepositorioEmpresa(self.conexao)
        self.repo_contrato = RepositorioContrato(self.conexao)

    def cadastrar_profissional(self, profissional: Profissional) -> None:
        self.repo_profissional.inserir(profissional)

    def listar_profissionais(self) -> list[Profissional]:
        return self.repo_profissional.listar_todos()

    def cadastrar_empresa(self, empresa: Empresa) -> None:
        self.repo_empresa.inserir(empresa)

    def listar_empresas(self) -> list[Empresa]:
        return self.repo_empresa.listar_todas()

    def registrar_contrato(self, contrato: Contrato) -> int:
        return self.repo_contrato.inserir(contrato)

    def listar_contratos(self) -> list[Contrato]:
        return self.repo_contrato.listar_todos()
