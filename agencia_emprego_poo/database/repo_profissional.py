import sqlite3

from models.profissional import Profissional


class RepositorioProfissional:
    def __init__(self, conexao):
        self.conn = conexao.conn if hasattr(conexao, "conn") else conexao

    def inserir(self, profissional: Profissional) -> None:
        self.conn.execute(
            "INSERT INTO profissional (cpf, nome, endereco, data_nascimento, profissao) VALUES (?, ?, ?, ?, ?)",
            (
                profissional.cpf,
                profissional.nome,
                profissional.endereco,
                profissional.data_nascimento,
                profissional.profissao,
            ),
        )
        self.conn.commit()

    def buscar_por_cpf(self, cpf: str) -> Profissional | None:
        row = self.conn.execute("SELECT * FROM profissional WHERE cpf = ?", (cpf,)).fetchone()
        if row is None:
            return None
        return Profissional(
            cpf=row["cpf"],
            nome=row["nome"],
            endereco=row["endereco"],
            data_nascimento=row["data_nascimento"],
            profissao=row["profissao"],
        )

    def listar_todos(self) -> list[Profissional]:
        rows = self.conn.execute("SELECT * FROM profissional ORDER BY nome").fetchall()
        return [
            Profissional(
                cpf=row["cpf"],
                nome=row["nome"],
                endereco=row["endereco"],
                data_nascimento=row["data_nascimento"],
                profissao=row["profissao"],
            )
            for row in rows
        ]

    def atualizar(self, profissional: Profissional) -> None:
        self.conn.execute(
            """
            UPDATE profissional
               SET nome = ?, endereco = ?, data_nascimento = ?, profissao = ?
             WHERE cpf = ?
            """,
            (
                profissional.nome,
                profissional.endereco,
                profissional.data_nascimento,
                profissional.profissao,
                profissional.cpf,
            ),
        )
        self.conn.commit()

    def remover(self, cpf: str) -> None:
        try:
            self.conn.execute("DELETE FROM profissional WHERE cpf = ?", (cpf,))
            self.conn.commit()
        except sqlite3.IntegrityError as exc:
            raise sqlite3.IntegrityError("Não é possível remover profissional com contratos vinculados") from exc
