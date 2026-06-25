from models.contrato import Contrato
from models.empresa import Empresa
from models.profissional import Profissional


class RepositorioContrato:
    def __init__(self, conexao):
        self.conn = conexao.conn if hasattr(conexao, "conn") else conexao

    def inserir(self, contrato: Contrato) -> int:
        cursor = self.conn.execute(
            """
            INSERT INTO contrato (cpf_profissional, cnpj_empresa, data_inicio, data_termino, valor_hora)
            VALUES (?, ?, ?, ?, ?)
            """,
            (
                contrato.profissional.cpf,
                contrato.empresa.cnpj,
                contrato.data_inicio,
                contrato.data_termino,
                contrato.valor_hora,
            ),
        )
        self.conn.commit()
        return int(cursor.lastrowid)

    def listar_todos(self) -> list[Contrato]:
        rows = self.conn.execute(
            """
            SELECT c.numero, c.data_inicio, c.data_termino, c.valor_hora,
                   p.cpf, p.nome, p.endereco, p.data_nascimento, p.profissao,
                   e.cnpj, e.razao_social, e.endereco AS endereco_empresa
              FROM contrato c
              JOIN profissional p ON p.cpf = c.cpf_profissional
              JOIN empresa e ON e.cnpj = c.cnpj_empresa
             ORDER BY c.numero DESC
            """
        ).fetchall()
        contratos = []
        for row in rows:
            profissional = Profissional(
                cpf=row["cpf"],
                nome=row["nome"],
                endereco=row["endereco"],
                data_nascimento=row["data_nascimento"],
                profissao=row["profissao"],
            )
            empresa = Empresa(cnpj=row["cnpj"], razao_social=row["razao_social"], endereco=row["endereco_empresa"])
            contratos.append(
                Contrato(
                    numero=row["numero"],
                    profissional=profissional,
                    empresa=empresa,
                    data_inicio=row["data_inicio"],
                    data_termino=row["data_termino"],
                    valor_hora=row["valor_hora"],
                )
            )
        return contratos

    def remover(self, numero: int) -> None:
        raise PermissionError("Contratos são imutáveis e não podem ser removidos")
