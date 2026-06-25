import sqlite3

from models.empresa import Empresa


class RepositorioEmpresa:
    def __init__(self, conexao):
        self.conn = conexao.conn if hasattr(conexao, "conn") else conexao

    def inserir(self, empresa: Empresa) -> None:
        self.conn.execute(
            "INSERT INTO empresa (cnpj, razao_social, endereco) VALUES (?, ?, ?)",
            (empresa.cnpj, empresa.razao_social, empresa.endereco),
        )
        self.conn.commit()

    def buscar_por_cnpj(self, cnpj: str) -> Empresa | None:
        row = self.conn.execute("SELECT * FROM empresa WHERE cnpj = ?", (cnpj,)).fetchone()
        if row is None:
            return None
        return Empresa(cnpj=row["cnpj"], razao_social=row["razao_social"], endereco=row["endereco"])

    def listar_todas(self) -> list[Empresa]:
        rows = self.conn.execute("SELECT * FROM empresa ORDER BY razao_social").fetchall()
        return [Empresa(cnpj=row["cnpj"], razao_social=row["razao_social"], endereco=row["endereco"]) for row in rows]

    def atualizar(self, empresa: Empresa) -> None:
        self.conn.execute(
            "UPDATE empresa SET razao_social = ?, endereco = ? WHERE cnpj = ?",
            (empresa.razao_social, empresa.endereco, empresa.cnpj),
        )
        self.conn.commit()

    def remover(self, cnpj: str) -> None:
        try:
            self.conn.execute("DELETE FROM empresa WHERE cnpj = ?", (cnpj,))
            self.conn.commit()
        except sqlite3.IntegrityError as exc:
            raise sqlite3.IntegrityError("Não é possível remover empresa com contratos vinculados") from exc
