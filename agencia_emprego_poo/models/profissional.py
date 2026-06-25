from dataclasses import dataclass

from models.pessoa import Pessoa


@dataclass
class Profissional(Pessoa):
    cpf: str
    data_nascimento: str
    profissao: str

    def __str__(self) -> str:
        return f"{self.nome} ({self.profissao}) - CPF: {self.cpf}"
