from __future__ import annotations

from dataclasses import dataclass
from datetime import date

from models.empresa import Empresa
from models.profissional import Profissional


@dataclass
class Contrato:
    profissional: Profissional
    empresa: Empresa
    data_inicio: str
    data_termino: str
    valor_hora: float
    numero: int | None = None

    def __post_init__(self) -> None:
        if self.profissional is None:
            raise ValueError("Contrato deve ter profissional associado")
        if self.empresa is None:
            raise ValueError("Contrato deve ter empresa associada")
        if self.valor_hora <= 0:
            raise ValueError("valor_hora deve ser maior que zero")

        inicio = date.fromisoformat(self.data_inicio)
        termino = date.fromisoformat(self.data_termino)
        if termino < inicio:
            raise ValueError("Data de término não pode ser anterior à data de início")

    def calcular_valor_total(self, horas: float) -> float:
        return self.valor_hora * horas

    def exibir_resumo(self) -> str:
        return (
            f"Contrato #{self.numero or 'novo'} | Profissional: {self.profissional.nome} | "
            f"Empresa: {self.empresa.razao_social} | "
            f"Vigência: {self.data_inicio} até {self.data_termino} | "
            f"R$ {self.valor_hora:.2f}/h"
        )

    @staticmethod
    def imprimir_detalhes(contrato: "Contrato", horas: float = 1.0) -> str:
        detalhes = (
            f"[{contrato.profissional.profissao}] {contrato.profissional.nome} -> "
            f"{contrato.empresa.razao_social} | "
            f"Total para {horas}h: R$ {contrato.calcular_valor_total(horas):.2f}"
        )
        print(detalhes)
        return detalhes
